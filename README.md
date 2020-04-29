# natCP

A free open source OpenVZ panel. Currently not being maintained, but a version for OpenVZ 7/LXC is being developed (https://github.com/FlamesRunner/containerCP).

## Master branch information

This branch contains the most recent STABLE version. Generally, it will have the least issues.

## Staging branch information

This branch contains the most recent version, however it is untested and will be pushed to the master branch once testing has been completed.

## Development branch information

This branch contains the most recent changes; it is not tested, and is unstable. Use at your own risk.
Pull requests should be created against this branch.

## Contributors

- Myself (Andrew. H)

## Screenshots

Listing virtual servers from the administrator panel:
![](https://s.flamz.pw/img/00be973b8f5e286a476333addc27fa7e.png)

Managing a virtual server as a standard user:
![](https://s.flamz.pw/img/17f029d8aaee5b10ac9c4b86f7be64e3.png)

## Slave node installation

Installing natCP on a slave node is easy.
Log on as the root user, and execute the following command:

    cd /tmp && wget https://raw.githubusercontent.com/FlamesRunner/natCP/master/slave/slaveInstall.sh --no-check-certificate
    bash /tmp/slaveInstall.sh

That's it. Make sure you save the slave access key, though!

Note: You will need to restart your system to enter with the OpenVZ kernel.

## Host node installation

Host node installation is a little more complicated.
First, you'll need to install a LEMP stack on your server. It's assumed that you already know how to do this.

Then, download the web directory, and move the contents to your NGINX web directory.
Afterwards, restore the MySQL table named 'restoreThis.sql' within the web directory into a database of your choice.

Enter your database details into the configuration file at the root of your web directory, and that should be it.

Last thing: To create your first user, please use the utility stored in the web directory, named 'createFirstUser.php' from the command line. An administrative user will be created using your database details and once you've logged in, you'll have the chance to change the password.

---
Want to donate? Send me a few dollars via PayPal: andrew@andrew-hong.me
