<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
<url>
<loc>{{ route('home')}}</loc>
<lastmod>{{ (new \DateTime())->format('Y-m-d\TH:i:sP') }}</lastmod>
<changefreq>daily</changefreq>
<priority>0.1</priority>
</url>
  <url>
<loc>{{ route('contact')}}</loc>
<lastmod>{{ (new \DateTime())->format('Y-m-d\TH:i:sP') }}</lastmod>
<changefreq>daily</changefreq>
<priority>0.1</priority>
</url>
  
  <url>
<loc>{{ route('exchangeHistory')}}</loc>
<lastmod>{{ (new \DateTime())->format('Y-m-d\TH:i:sP') }}</lastmod>
<changefreq>daily</changefreq>
<priority>0.1</priority>
</url>
  
    <url>
        <loc>{{ route('tutorial')}}</loc>
<lastmod>{{ (new \DateTime())->format('Y-m-d\TH:i:sP') }}</lastmod>
<changefreq>daily</changefreq>
<priority>0.1</priority>
</url>
  
  
  
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('love.details', ['slug'=>slug($post->post_slug)]) }}</loc>
            <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
  
  
     @foreach ($users as $user)
        <url>
            <loc>{{ route('user', ['slug'=>$user->slug]) }}</loc>
            <lastmod>{{ $user->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
