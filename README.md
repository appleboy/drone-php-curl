# drone-php-curl

php curl for drone plugin

## drone plugin example

```yml
pipeline:
  webhook:
    image: foo/webhook
    url: http://foo.com
    method: post
    body: |
      hello world
```
