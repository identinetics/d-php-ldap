FROM centos:centos7
LABEL maintainer="Rainer Hörbe <r2h2@hoerbe.at>" \
      version="0.0.0" \
      #UID_TYPE: select one of root, non-root or random to announce container behavior wrt USER
      UID_TYPE="random" \
      capabilities='--cap-drop=all'

ARG USERNAME=phpldaptest
RUN useradd $USERNAME \
 && yum -y update \
 && yum -y install php php-ldap \
 && yum clean all

USER $USERNAME
CMD [ "/opt/bin/test_ldap.php" ]
