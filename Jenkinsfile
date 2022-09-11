pipeline {
  agent any
	environment {
    NGINX_IMAGE_NAME = 'kurtay/nginx'
    PHP_IMAGE_NAME = 'kurtay/php'
    IMAGE_TAG = 'sym-tut'
	}
  stages {
    stage('Clone') {
      steps {
        git url: 'https://github.com/dakual/symfony-ci-cd-tutorial.git'
      }
    }
    stage('Build nginx') {
      steps {
        sh 'docker build -t $NGINX_IMAGE_NAME:$IMAGE_TAG -f ./nginx/Dockerfile .'
      }
    }
    stage('Build php') {
      steps {
        sh 'docker build -t $PHP_IMAGE_NAME:$IMAGE_TAG -f ./php/Dockerfile .'
      }
    }      
    stage('Push to registry') {
      steps {
        sh 'docker image push $NGINX_IMAGE_NAME:$IMAGE_TAG'
        sh 'docker image push $PHP_IMAGE_NAME:$IMAGE_TAG'
      }
    }       
    stage('Deploy to k8s') {
      steps {
        sh 'kubectl apply -f k8s/deployment.yml'
        sh 'kubectl apply -f k8s/service.yml'
      }
    }  
  }
  post {
    always {
      sh 'docker logout'
    }
  }
}