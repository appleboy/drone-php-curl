# Example PHP Plugin

This provides a brief tutorial for creating a Drone webhook plugin, using simple php scripting, to make an http requests during the build pipeline. The below example demonstrates how we might configure a webhook plugin in the Yaml file:

```yml
pipeline:
  webhook:
    image: foo/webhook
    url: http://foo.com
    method: post
    body: |
      hello world
```

Create a simple shell script that invokes curl using the Yaml configuration parameters, which are passed to the script as environment variables in uppercase and prefixed with `PLUGIN_`.

```php
<?php

$method = getenv('PLUGIN_METHOD');
$body = getenv('PLUGIN_BODY');
$url = getenv('PLUGIN_URL');

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
if ($method === "post") {
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
}

$output = curl_exec($ch);
curl_close($ch);
echo $output;
```

Create a Dockerfile that adds your shell script to the image, and configures the image to execute your shell script as the main entrypoint.

```dockerfile
FROM laradock/workspace:1.8-71

ADD curl.php /

ENTRYPOINT ["php", "curl.php"]
```

Build and publish your plugin to the Docker registry. Once published your plugin can be shared with the broader Drone community.

```sh
docker build -t foo/webhook .
docker push foo/webhook
```

Execute your plugin locally from the command line to verify it is working:

```sh
docker run --rm \
  -e PLUGIN_METHOD=post \
  -e PLUGIN_URL=http://foo.com \
  -e PLUGIN_BODY="hello world" \
  foo/webhook
```
