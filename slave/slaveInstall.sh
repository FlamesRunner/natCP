#!/bin/bash
echo "                     #####  ######  "
echo "#    #   ##   ##### #     # #     # "
echo "##   #  #  #    #   #       #     # "
echo "# #  # #    #   #   #       ######  "
echo "#  # # ######   #   #       #       "
echo "#   ## #    #   #   #     # #       "
echo "#    # #    #   #    #####  #       "
echo " "
echo "-------> Installer v0.01            "
echo "----> Installing natCP v0.5 slave   "
echo "-> You have 10 seconds to cancel.   "
echo " "

if [ ! -e "/etc/centos-release" ]; then
echo "Warning: Only servers running CentOS 6.x are supported."
exit 1
fi

sleep 10
echo "-> Installing packages"
yum install -y git expr bc &> /dev/null 
echo "-> Downloading natCP files..."
cd /tmp && git clone https://github.com/FlamesRunner/natCP
mv /tmp/natCP/slave /tmp/slave && rm -rf /tmp/natCP
chmod 700 /tmp/slave/*
mv /tmp/slave/* /sbin
echo "-> Installing OpenVZ kernel"
wget -P /etc/yum.repos.d/ https://download.openvz.org/openvz.repo
rpm --import http://download.openvz.org/RPM-GPG-Key-OpenVZ
yum install vzkernel -y
echo "-> Installing OpenVZ tools"
yum install vzctl vzquota ploop -y
echo "-> Installation complete. Please wait while final configuration changes are made."
newPassword=$(openssl rand -base64 32)
useradd remote
mkdir -p /srv/consoleusers/
mkdir -p /srv/containers
groupadd consoleusers
echo '%consoleusers ALL=NOPASSWD:/sbin/vzenter' >> /etc/sudoers
sed -i 's/VE_LAYOUT=ploop/VE_LAYOUT=simfs/g' /etc/vz/vz.conf
chmod 755 /sbin/vzenter
echo -e "$newPassword\n$newPassword" | passwd remote
echo 'remote ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
echo "-> Slave node configured. Here are the slave details:"
echo "-> Access key: $newPassword"
echo "-> Note: A reboot is required. Failiure to do so will prevent the proper installation of the OpenVZ kernel."
