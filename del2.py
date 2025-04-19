import os
import re

dd = {
    "新坦达（上海）资产管理有限公司": "Standard Human Capital",
    "联系我们": "Contact Us",
    "管理层": "Management Team",
    "发展历程": "Development History",
    "业务优势": "Business Advantages",
    "愿景文化": "Vision & Culture",
    "行业专项业务": "Industry-Specific",
    "职能专项业务": "Function-Specific",
    "财富管理咨询": "Wealth Management",
    "董事会服务": "Board Services",
    "企业领袖评估": "Leadership Assessment",
    "企业领袖发展": "Leadership Development",
    "操作准则": "Operating Guidelines",
    "styles.css": "english_styles.css"
}


for file in os.listdir("templates"):
    if not ".html" in file:
        continue

    lines = []
    with open("templates/"+file, "r") as f:
        lines = f.readlines()
    

    new_lines = []
    for line in lines:
        for k in dd:
            if k in line:
                line = re.sub(k, dd[k], line)
                break
        line = re.sub('style=\"padding-left:34px; width:81px;\"', '', line)
        line = re.sub('<a href=\"javascript:void\(0\)\" class=\"top_icon_s\">English<\/a>', \
                      '<a href="/set_language/zh" class="top_icon_s">Chinese</a>', line)
        

        new_lines.append(line)
    
    with open("templates/english/"+file, "w+") as f:
        for new_line in new_lines:
            f.write(new_line)

        
                




