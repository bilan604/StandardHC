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
The committed `myenv/` and `venv/` folders are Linux virtual environments and won't work on Windows or macOS, so make a fresh one called `.venv` (it's gitignored). The app only needs `flask` and `python-dotenv` to serve pages.  

#### Windows (PowerShell)  
```
python -m venv .venv
.venv\Scripts\Activate.ps1
pip install flask python-dotenv
flask --app app run --host 127.0.0.1 --port 8000
```

#### macOS / Linux  
```
python3 -m venv .venv
source .venv/bin/activate
pip install flask python-dotenv gunicorn
gunicorn --bind 127.0.0.1:8000 app:app
```
(`flask --app app run --host 127.0.0.1 --port 8000` also works here.)  

Then open http://127.0.0.1:8000 in a browser. Press `Ctrl+C` to stop the server.  
<b>NOTE</b>: gunicorn doesn't run on Windows, so use Flask's built-in server there. The contact form sends email with the settings in `.env`.  


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



---

# StandardHC（中文版）

## 分支  
<b>main</b>：供 GCP 跟踪的分支，运行线上应用。  

<b>staging</b>：中间分支，用于在 GCP 上测试更改，而不会在合并到 main 之前覆盖上一个版本。  

<b>development</b>：本地开发应在此分支进行。  

## 项目在 Google Cloud 上的配置方式  

应用托管在 Google Cloud 上的一台 Linux 虚拟机中。我通过浏览器中的 bash 终端（SSH-in-browser）访问该虚拟机。本应用使用 Python 的 Flask 库处理后端网络请求，但使用 gunicorn 启动，因为用 gunicorn 配置 SSL 证书比较方便。  

#### 依赖：通过 sudo apt 安装（GCP 终端语法）：
<b>git</b>：`sudo apt install git`  
<b>python3</b>：`sudo apt install python3 python3-pip`  
<b>pip</b>：可能需要安装，不确定  
<b>nginx</b>：`sudo apt install python3-pip python3-venv nginx git`  

<b>虚拟环境</b>：尽早创建并启动虚拟环境。  
--<b>创建</b>：`python3 -m venv myenv`  
--<b>启动</b>：`source myenv/bin/activate`  

#### 依赖：通过 pip 安装（GCP 终端语法）：  
<b>注意</b>：需要在虚拟环境中执行  
`pip install flask gunicorn`  

#### 与 nginx、SSL 证书、防火墙等相关的操作步骤：  
1. 我认为首先需要在 GCP 中指定地址 `http://127.0.0.1:8000`，以便监听该项目/机器。  
2. 创建文件：`sudo nano /etc/nginx/sites-available/flaskapp`
文件内容：  
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
3. 启用该配置：`sudo ln -s /etc/nginx/sites-available/flaskapp /etc/nginx/sites-enabled`  
4. 重启以应用更改（顺序不确定）：`sudo systemctl restart nginx`  
5. GCP：为服务器配置 SSL（HTTPS 所必需）：`sudo apt install certbot python3-certbot-nginx`  
6. GCP：进入 GCP 的 Cloud Domain API 控制台，进入 zones，添加一条 ‘A’ DNS 记录  
7. 修改 GCP 项目/应用的防火墙设置，允许 HTTP 和 HTTPS 流量（tcp:80、tcp:443）  
8. 在 `main.py` 中让 Flask 应用运行在 http://127.0.0.1/8000：`app.run(host=http://127.0.0.1/8000“)`  


## 在 GCP 上运行应用  
如果当前工作目录不是 StandardHC，请先进入该目录：  
```
cd StandardHC  
```

检查应用是否正在 GCP 上运行：  
```
ps aux | grep python  
```

如果应用正在 GCP 上运行，将其终止：  
```
kill [process_id]
```
process_id 是运行 `ps aux | grep python` 后找到的该应用的 3–5 位数字进程号。  

在 GCP 上激活虚拟环境（非常重要）：  
```
source myenv/bin/activate  
```

运行应用：  
```
nohup gunicorn --bind 127.0.0.1:8000 app:app &  
```
--`nohup` 表示日志的存放位置（存入名为 `nohup.out` 的日志文件）  
--末尾的 `&` 让应用在 SSH 终端窗口关闭后仍继续运行。  


## 在本地运行应用  
仓库中提交的 `myenv/` 和 `venv/` 文件夹是 Linux 虚拟环境，在 Windows 或 macOS 上无法使用，因此需要新建一个名为 `.venv` 的虚拟环境（已被 gitignore 忽略）。应用只需要 `flask` 和 `python-dotenv` 即可提供页面。  

#### Windows（PowerShell）  
```
python -m venv .venv
.venv\Scripts\Activate.ps1
pip install flask python-dotenv
flask --app app run --host 127.0.0.1 --port 8000
```

#### macOS / Linux  
```
python3 -m venv .venv
source .venv/bin/activate
pip install flask python-dotenv gunicorn
gunicorn --bind 127.0.0.1:8000 app:app
```
（这里也可以使用 `flask --app app run --host 127.0.0.1 --port 8000`。）  

然后在浏览器中打开 http://127.0.0.1:8000。按 `Ctrl+C` 停止服务器。  
<b>注意</b>：gunicorn 不支持 Windows，因此在 Windows 上请使用 Flask 自带的服务器。联系表单会使用 `.env` 中的配置发送邮件。  


## 常用命令  
```
cd StandardHC
source myenv/bin/activate
gunicorn --bind 127.0.0.1:8000 app:app
nohup gunicorn --bind 127.0.0.1:8000 app:app &
```


## 备注  
关于 html 文件制作方式的备注。  

1. 检查并复制 <html> 标签，粘贴到本地文件中  
2. 在浏览器的 Sources 中获取 css 文件内容，并将 css 放入 html 文件的 <style> 块中  
3. 复制 html 文件，用它替换 del.py 中的变量 s，然后运行 del.py 生成新版 html 文件  
4. 修正图片引用（例如 uploadfiles/ -> ../static/uploadfiles）（如果在 <styles> 块中，使用 background:url(static/images/top_line2.gif)；如果是行内 css，使用 background:url(../static/images/top_line2.gif)）  


## 待办  
不知为何以下页面的字体过大：  
/cases/  
除此之外，所有页面除了内容上的改动外都完全相同。  
