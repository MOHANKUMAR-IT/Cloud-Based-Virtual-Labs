FROM python
ENV SIAB_USERCSS='Normal:+/etc/shellinabox/options-enabled/00+Black-on-White.css,Reverse:-/etc/shellinabox/options-enabled/00_White-On-Black.css;Colors:+/etc/shellinabox/options-enabled/01+Color-Terminal.css,Monochrome:-/etc/shellinabox/options-enabled/01_Monochrome.css' \
SIAB_PORT=4200 \
SIAB_ADDUSER=true \
SIAB_USER=MohanKumarR \
SIAB_USERID=1000 \
SIAB_GROUP=MohanKumarR \
SIAB_GROUPID=1000 \
SIAB_PASSWORD=2001 \
SIAB_SHELL=/bin/bash \
SIAB_HOME=/home/MohanKumarR \
SIAB_SUDO=true \
SIAB_SSL=false \
SIAB_SERVICE=/:LOGIN \
SIAB_PKGS=none \
SIAB_SCRIPT=none

RUN apt-get update && apt-get install -y openssl curl openssh-client sudo shellinabox && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    ln -sf '/etc/shellinabox/options-enabled/00+Black on White.css' \
    /etc/shellinabox/options-enabled/00+Black-on-White.css && \
    ln -sf '/etc/shellinabox/options-enabled/00_White On Black.css' \
    /etc/shellinabox/options-enabled/00_White-On-Black.css && \
    ln -sf '/etc/shellinabox/options-enabled/01+Color Terminal.css' \
    /etc/shellinabox/options-enabled/01+Color-Terminal.css

EXPOSE 4200
EXPOSE 80
EXPOSE 443
VOLUME /etc/shellinabox /var/log/supervisor /home

ADD assets/entrypoint.sh /usr/local/sbin/

ENTRYPOINT ["entrypoint.sh"]
CMD ["shellinabox"]