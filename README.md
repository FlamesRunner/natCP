# natCP

A free open source OpenVZ panel tailored for NAT containers

##Installation:

###Slave node installation#

*Note: Installation should be on a CentOS x86_64 node*

Fortunately, setting up a slave node is quite easy.
First, log on to the server which you want as a slave and copy any files from natCP/slave in this repository to /sbin.
Then, give these files the proper permissions (700 is recommended).

Create a user named 'remote', and set a password.
Set the password (use the following command for a secure password):
    
    openssl rand -base64 95
    passwd remote

Now, open up `visudo`. Add an entry that looks like this:

    remote ALL=(ALL) NOPASSWD: /sbin/containermanager, /sbin/get_available_templates

This will grant remote access to only what it needs.

It is required that you install the OpenVZ kernel, so follow these commands:

    wget -P /etc/yum.repos.d/ https://download.openvz.org/openvz.repo
    rpm --import http://download.openvz.org/RPM-GPG-Key-OpenVZ
    yum install vzkernel
    
Add this to your `/etc/sysctl.conf` file:

    net.ipv6.conf.default.forwarding = 1
    net.ipv6.conf.all.forwarding = 1
    net.ipv6.conf.all.proxy_ndp = 1
    net.ipv6.bindv6only = 1
    net.ipv4.conf.default.proxy_arp=0
    net.ipv4.conf.default.send_redirects=1
    net.ipv4.conf.all.send_redirects=0
    
And reboot.

natCP requires that you also have a private IPv4 subnet for containers, so create it as follows:

    ip addr add 10.42.1.1/24 dev eth0
    iptables -t nat -A POSTROUTING -s 10.42.1.1/24 -o eth0 -j SNAT --to your.public.ip
    iptables -A FORWARD -s 10.42.1.1/24 -j ACCEPT
    iptables -A FORWARD -d 10.42.1.1/24 -j ACCEPT
    service iptables save
    
If you don't have IPv6 available natively, you can get this at https://tunnelbroker.net/.

Open up `/sbin/containermanager`, find the configuration options at the top and change them.

That's it for slave installation, moving on to host node creation...

###Host node installation

This one is quite simple - install yourself a web server and PHP (recommended: NGINX + PHP-FPM)
Then, copy the contents of the web/ folder into the directory of which a virtual host resides.
Edit `manager/config.php` and make changes as necessary.

---

Want to donate? Send me a few dollars via PayPal: andrew@andrew-hong.me
