from django.contrib.syndication.views import Feed
from .models import Blog

class LatestEntriesFeed(Feed):
    title = "Latest News Blog Posts"
    link = "/rss/"
    description = "Updates on the latest blog posts from our news portal."

    def items(self):
        # Return the latest 5 posts for the feed
        return Blog.objects.order_by('-published_date')[:5]

    def item_title(self, item):
        return item.title

    def item_description(self, item):
        # Truncate content for description
        return item.content[:100] + "..."

    def item_pubdate(self, item):
        return item.published_date
