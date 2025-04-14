




dd = {
    'href="/zh_cn/default/index.html"': "/",

    'href="/zh_cn/service/index.html"': "/service",
    'href="/zh_cn/service/industry-specific.html"': "/service",
    'href="/zh_cn/service/function-specific.html"': "/service_function_specific",
    'href="/zh_cn/service/caiwuguanlizixun.html"': "/service_caiwuguanlizixun",
    'href="/zh_cn/service/directors.html"': "/service_directors",

    'href="/zh_cn/process/index.html"': "/process",
    'href="/zh_cn/process/assess.html"': "/process",
    'href="/zh_cn/process/development.html"': "/process_development",
    'href="/zh_cn/process/operating-guidelines.html"': "/process_operating_guidelines",

    'href="/zh_cn/about/index.html"': "/about",
    'href="/zh_cn/about/management_layer.html"': "/about",
    'href="/zh_cn/about/history.html"': "/about_history",
    'href="/zh_cn/about/advantage.html"': "/about_advantage",
    'href="/zh_cn/about/cultural_vision.html"': "/about_cultural_vision",

    'href="/zh_cn/cases/index.html"': "/cases",
    'href="/zh_cn/contact/index.html"': "/contact",

    'href="/zh_cn/statement/index.html"': "/",
    'href="/zh_cn/sitemap/index.html"': "/"
}

for k in dd:
    v = dd[k]
    dd[k] = f'href=\"{v}\"'

print(dd)
