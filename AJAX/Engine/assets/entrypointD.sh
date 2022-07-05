#!/bin/bash
echo "Preparing container .. Help Me"
groupadd -g 1000 CloudLab
useradd -u 1000 -g CloudLab -s /bin/bash -d /home/CloudLab -m  CloudLab
usermod -aG sudo CloudLab
echo CloudLab:2001 | /usr/sbin/chpasswd
exec /usr/bin/shellinaboxd --debug --no-beep --disable-peer-check -u shellinabox -g shellinabox -c /var/lib/shellinabox -p 4200 --user-css 'Normal:+/etc/shellinabox/options-enabled/00+Black-on-White.css,Reverse:-/etc/shellinabox/options-enabled/00_White-On-Black.css;Colors:+/etc/shellinabox/options-enabled/01+Color-Terminal.css,Monochrome:-/etc/shellinabox/options-enabled/01_Monochrome.css' -t 
