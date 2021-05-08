FROM centos:7
LABEL Component="nginx" \
      Name="centos/nginx-centos7" \
      version="1.0.0" \
      release="1" \
      aythor="JanoPL"

RUN yum -y install --setopt=tsflags=nodocs centos-release-scl-rh epel-release && \
    yum -y update --setopt=tsflags=nodocs && \
    yum -y install --setopt=tsflags=nodocs scl-utils nginx iproute && \
    yum clean all

RUN mkdir -p /usr/share/nginx/html

ADD ./nginx/root /

# ADD https://git.centos.org/sources/httpd/c7/acf5cccf4afaecf3afeb18c50ae59fd5c6504910 /usr/share/nginx/html/
# RUN sed -i -e 's/Apache/nginx/g' -e '/apache_pb.gif/d' /usr/share/nginx/html/index.html
#RUN echo "nginx on CentOS7" > /usr/share/nginx/html/index.html

RUN ["chmod", "+x", "/usr/bin/container-entrypoint" , "/usr/bin/nginx_script"]

ENTRYPOINT ["/usr/bin/container-entrypoint"]

CMD [ "/usr/bin/nginx_script" ]
