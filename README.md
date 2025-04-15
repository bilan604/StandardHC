# StandardHC

## Branches  
<b>main</b>: The branch meant for GCP to track, running the live application.  

<b>staging</b>: A middle-man branch used to test changes on GCP without overwriting the previous version before adding changes to main.  

<b>development</b>: Where local work should be done.  

## How The Project Was Set Up On Google Cloud  

There is a linux virtual machine running on Google Cloud that hosts the application. I access the VM by opening a bash terminal on my browser (SSH-in-browser). This application uses python's Flask library to handle backend web requests, but it's launched using gunicorn because gunicorn was convenient to set up the SSL Certificate with.  

#### Dependency: Installed via sudo apt (GCP Terminal Syntax):
<b>git</b>: `sudo apt install git`  
<b>python3</b>: `sudo apt install python3 python3-pip`  
<b>pip</b>: Might need to install. Not sure  
<b>nginx</b>: `sudo apt install python3-pip python3-venv nginx git`  

<b>A Virtual Environment</b>: Create the virtual environment and start it as soon as possible.  
--<b>Creating</b>:`python3 -m venv myenv`  
--<b>Starting</b>:`source myenv/bin/activate`  

#### Dependency: Installed via pip (GCP Terminal Syntax):  
<b>NOTE</b>: Syntax requires being inside the virtual environement  
`pip install flask gunicorn`  

#### Actionable requirements specific related to nginx, SSL certificate, firewall, etc:  
1. I believe first the address `http://127.0.0.1:8000` must be specified in GCP for the project/machine to be listened to.  
2. create file: `sudo nano /etc/nginx/sites-available/flaskapp`
File Contents:  
```
server {
    listen 80;
    server_name standard-hc.com www.standard-hc.com;

    location / {
        proxy_pass http://127.0.0.1:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```  
3. Do something to enable it: `sudo ln -s /etc/nginx/sites-available/flaskapp /etc/nginx/sites-enabled`  
4. Restart to apply changes (Order uncertain): `sudo systemctl restart nginx`  
5. GCP: Securing server with SSL (required for HTTPS): `sudo apt install certbot python3-certbot-nginx`  
6. GCP: Go to GCP's Cloud Domain API dashboard, go to zones, and add an ‘A’ DNS record  
7. Modify the GCP project/application's firewall settings to allow HTTP and HTTPS traffic (tcp:80, tcp:443)  
8. Tell the flask app to run on http://127.0.0.1/8000 in `main.py`: `app.run(host=http://127.0.0.1/8000“)`  


## Running the Application on GCP  
If the current working directory is not StandardHC, then cd into it:  
```
cd StandardHC  
```

Check if the application is running on GCP:  
```
ps aux | grep python  
```

Kill the application if it is running on GCP:  
```
kill [process_id]
```
The process_id should be a 3-5 digit numerical sequence for the application found by running `ps aux | grep python`  

Activate the virtual environment if on GCP (VERY IMPORTANT):  
```
source myenv/bin/activate  
```

Run the application:  
```
nohup gunicorn --bind 127.0.0.1:8000 app:app &  
```
--`nohup` indicates where the logs are going to be stored (into a log file named `nohup.out`)  
--`&` at the end tells the application to keep running even when the SSH terminal window is closed.  


## Running the Application Locally  
```
gunicorn --bind 127.0.0.1:8000 app:app  
```


## Frequently Used  
```
cd StandardHC
source myenv/bin/activate
gunicorn --bind 127.0.0.1:8000 app:app
nohup gunicorn --bind 127.0.0.1:8000 app:app &
```


## Notes  
Notes on how the html files were created.  

1. Inspect and copy the <html> tag and paste into local file  
2. Go to browser sources and get the css file contents and add the css in a <style> block in the html file  
3. Copy the html file and replace variable s in del.py with it and run it to get the new version of the html file  
4. Fix the image references (i.e. uploadfiles/ -> ../static/uploadfiles) (if its in the <styles> block then use background:url(static/images/top_line2.gif), if it's inline css then use background:url(../static/images/top_line2.gif))  


## TODO  
For some reason the font sizes are too larger on:  
/cases/  
Otherwise all the pages are identical except forr qualitative changes.  

