pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                sh '''
                echo 'Building ..'
                ln -sf conf.sh.default conf.sh
                ./dscripts/build.sh -p
                '''
            }
        }
        stage('Test PHP client library') {
            steps {
                sh '''
                ln -sf ldapenv.conf.default ldapenv.conf
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
