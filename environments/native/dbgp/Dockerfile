FROM alpine:3.16

MAINTAINER Grégory Planchat <gregory@kiboko.fr>

RUN set -ex \
    && apk add \
        py2-pip \
    && pip2 install --upgrade pip \
    && pip2 install komodo-python-dbgp

CMD /usr/bin/pydbgpproxy -d 0.0.0.0:9000 -i 0.0.0.0:9001

EXPOSE 9000 9001