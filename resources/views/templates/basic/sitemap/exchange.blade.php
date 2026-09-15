<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
<url>
<loc>https://pmbuysell.com/exchange/History</loc>
<lastmod>2023-02-18T13:33:51+00:00</lastmod>
<changefreq>daily</changefreq>
<priority>0.1</priority>
</url>
  
    @foreach ($exchanges as $post)
        <url>
            <loc>{{ route('exchangeDetail', $post->exchange_id) }}</loc>
            <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach

</urlset>
