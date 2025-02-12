# <?php die(); ?>

default_index:
  regex: /
  defaults:
    namespace: default
    controller: default
    action: index
  config:

page_index:
  regex: /(zh_cn|en_us)/(.+)/index.html
  defaults:
    namespace: default
    controller: default
    action: index
  config:
    ln: 1
    controller: 2

article_list:
  regex: /(zh_cn|en_us)/article/list-([0-9]+)\.html
  defaults:
    namespace: default
    controller: article
    action: index
    page: 1
  config:
    ln: 1
    page: 2

article_detail:
  regex: /(zh_cn|en_us)/article/detail/([a-zA-Z0-9]+)\.html
  defaults:
    namespace: default
    controller: article
    action: detail
  config:
    ln: 1
    page_name: 2

product:
  regex: /(zh_cn|en_us)/(.+)/(.+)\.html
  defaults:
    namespace: default
    controller: default
    action: index
  config:
    ln: 1
    controller: 2
    frame_name: 3



_default_: 
  pattern: /:namespace/:controller/:action/*
  defaults: 
    namespace: default
    controller: default
    action: index
