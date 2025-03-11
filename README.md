# StandardHC

## Branches  
main: The branch meant for GCP to track, running the live application.  

staging: A middle-man branch used to test changes on GCP without overwriting the previous version before adding changes to main.  

development: Where local work should be done.  


#### Before Running:  
If the current working directory is not StandardHC, then cd into it. Activate the virtual environment (VERY IMPORTANT).
```
cd StandardHC  
source myenv/bin/activate  
```

-'nohup' indicates where the logs are going to be stored (into a log file named `nohup.out`)  

-The '&' at the end tells the application to keep running even when the SSH terminal window is closed.  


#### Checking if the application is running on GCP:  
```
ps aux | grep python  
```


#### Killing the application if it is running on GCP:  
```
kill [process_id]
```

The process_id should be a 3-5 digit numerical sequence for the application found by running `ps aux | grep python`  


#### Run the application locally:  
```
gunicorn --bind 127.0.0.1:8000 app:app  
```


#### Run the application on GCP:  
```
nohup gunicorn --bind 127.0.0.1:8000 app:app &  
```



