pipeline {
    agent any
    stages {
        /*stage('Git pull + branch + submodule') {
            steps {
                sh '''
                #http_proxy=${env.http_proxy}
                #https_proxy=${env.https_proxy}
                #echo 'pulling updates'
                #git pull
                git submodule update --init
                cd ./dscripts && git checkout master && git pull && cd -
                '''
            }
        }*/
        stage('Build') {
            steps {
                sh '''
                echo 'Building ..'
                rm conf.sh 2> /dev/null || true
                ln -s conf.sh.default conf.sh
                ./dscripts/build.sh -p
                '''
            }
        }
        stage('Test PHP client library') {
            steps {
                sh '''
                echo "clone d-php-ldap"
                if [[ ! "d-php-ldap" ]]; then
                    git clone git@github.com:identinetics/d-php-ldap.git
                    cd d-php-ldap
                    git submodule update --init
                else
                    cd d-php-ldap
                    git pull
                fi
                ln -sf conf.sh.default conf.sh
                ln -sf ldapenv.conf.default ldapenv.conf
                ./dscripts/build.sh
                ./dscripts/run.sh -I
                '''
            }
        }
    }
    post {
        always {
            echo 'removing docker container'
            sh '''
            ./dscripts/manage.sh rm 2>&1 || true
            '''
        }
    }
}
