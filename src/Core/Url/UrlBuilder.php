<?php
namespace Pars\Core\Url;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class UrlBuilder
{
    protected UriInterface $baseUri;

    protected UriInterface $uri;

    public function __construct()
    {
        $this->baseUri = new Uri();
        $this->uri = new Uri();
    }

    public function addBaseUri(UriInterface $uri)
    {
        $this->baseUri = $this->merge($this->baseUri, $uri);
        return $this;
    }

    public function withUri(UriInterface $uri): static
    {
        $clone = clone $this;
        $clone->uri = $uri;
        return $clone;
    }

    public function withParams(array $params): static
    {
        $clone = clone $this;
        $clone->uri = $clone->uri->withQuery(http_build_query($params));
        return $clone;
    }

    public function withPath(string $path): static
    {
        $clone = clone $this;
        $clone->uri = $clone->uri->withPath($path);
        return $clone;
    }

    public function __clone()
    {
        $this->baseUri = clone $this->baseUri;
        $this->uri = clone $this->uri;
    }

    public function __toString()
    {
        return $this->merge($this->baseUri, $this->uri)->__toString();
    }

    public function merge(UriInterface $base, UriInterface $append): UriInterface
    {
        $result = new Uri();
        $result = $result->withPath($base->getPath() . $append->getPath());
        if ($append->getQuery()) {
            if ($base->getQuery()) {
                $query = $base->getQuery() . '&' . $append->getQuery();
            } else {
                $query = $append->getQuery();
            }
            $result = $result->withQuery($query);
        }
        return $result;
    }
}