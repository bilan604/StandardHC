# StandardHC

## PLEASE READ!!!!    
The GCP instance tracks the development branch. Please do not edit files on vscode and/or push from local to development.  


Running:  
```
cd StandardHC  
source myenv/bin/activate
```

If on local:
`gunicorn --bind 127.0.0.1:8000 app:app`
If on GCP:
`nohup gunicorn --bind 127.0.0.1:8000 app:app &`