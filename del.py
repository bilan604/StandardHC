import re

dd = {'href="/zh_cn/default/index.html"': 'href="/"', 'href="/zh_cn/service/index.html"': 'href="/service"', 'href="/zh_cn/service/industry-specific.html"': 'href="/service"', 'href="/zh_cn/service/function-specific.html"': 'href="/service_function_specific"', 'href="/zh_cn/service/caiwuguanlizixun.html"': 'href="/service_caiwuguanlizixun"', 'href="/zh_cn/service/directors.html"': 'href="/service_directors"', 'href="/zh_cn/process/index.html"': 'href="/process"', 'href="/zh_cn/process/assess.html"': 'href="/process"', 'href="/zh_cn/process/development.html"': 'href="/process_development"', 'href="/zh_cn/process/operating-guidelines.html"': 'href="/process_operating_guidelines"', 'href="/zh_cn/about/index.html"': 'href="/about"', 'href="/zh_cn/about/management_layer.html"': 'href="/about"', 'href="/zh_cn/about/history.html"': 'href="/about_history"', 'href="/zh_cn/about/advantage.html"': 'href="/about_advantage"', 'href="/zh_cn/about/cultural_vision.html"': 'href="/about_cultural_vision"', 'href="/zh_cn/cases/index.html"': 'href="/cases"', 'href="/zh_cn/contact/index.html"': 'href="/contact"', 'href="/zh_cn/statement/index.html"': 'href="/"', 'href="/"': 'href="/"'}

s = """




""".strip()


print("----------------------->\n\n")
lines = s.split("\n")

for i in range(len(lines)):
    line = lines[i]
    line = line.strip()
    
    if not line:
        print(line)
        continue

    # cond A)
    if ("background:url(../images" in line) and ((".jpg" in line) or (".gif" in line)):
        line = re.sub("background:url\(\.\.\/images", "background:url(static/images", line)
        print(line)
        continue


    if not (("href=" in line) and (".html" in line) and ("/zh_cn/" in line)):
        print(line)
        continue

    a = None
    for k in dd:
        if k in line:
            a = k
            break

    if a == None:
        print(line)
        continue
    
    line = re.sub(a, dd[a], line)
    print(line)

    
print("\n\n<-----------------------")


