# StandardHC

## Branches  
<b>main</b>: The branch meant for GCP to track, running the live application.  

<b>staging</b>: A middle-man branch used to test changes on GCP without overwriting the previous version before adding changes to main.  

<b>development</b>: Where local work should be done.  

## Google Cloud  

There is a linux virtual machine running on Google Cloud that hosts the application. I am accessing the VM by opening a bash terminal on my browser.  

This application uses python's Flask library to handle backend web requests. It's launched using gunicorn because gunicorn was convenient to set up the SSL Certificate with.  

## Before Running  
If the current working directory is not StandardHC, then cd into it. Activate the virtual environment (VERY IMPORTANT).
```
cd StandardHC  
source myenv/bin/activate  
```

-`nohup` indicates where the logs are going to be stored (into a log file named `nohup.out`)  

-The `&` at the end tells the application to keep running even when the SSH terminal window is closed.  


## Check if the application is running on GCP  
```
ps aux | grep python  
```


## Kill the application if it is running on GCP  
```
kill [process_id]
```

The process_id should be a 3-5 digit numerical sequence for the application found by running `ps aux | grep python`  


## Run the application locally  
```
gunicorn --bind 127.0.0.1:8000 app:app  
```


## Run the application on GCP  
```
nohup gunicorn --bind 127.0.0.1:8000 app:app &  
```



