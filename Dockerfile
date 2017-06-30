FROM laradock/workspace:1.8-71

ADD curl.php /

ENTRYPOINT ["php", "curl.php"]
