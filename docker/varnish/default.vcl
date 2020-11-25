vcl 4.0;

backend app {
    .host = "app:80";
}

sub vcl_deliver {
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }

    set resp.http.X-Cache-Hits = obj.hits;

    unset resp.http.Server;
    unset resp.http.Via;
    unset resp.http.X-Powered-By;
    unset resp.http.X-Varnish;

    return (deliver);
}
