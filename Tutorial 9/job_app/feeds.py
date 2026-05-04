from django.contrib.syndication.views import Feed
from .models import Job

class LatestJobsFeed(Feed):
    title = "Job Portal: Latest Openings"
    link = "/jobs/feed/"
    description = "New job opportunities posted on our portal."

    def items(self):
        # Latest 10 job postings
        return Job.objects.order_by('-posted_date')[:10]

    def item_title(self, item):
        return f"{item.job_title} - {item.company_name}"

    def item_description(self, item):
        return item.description[:150] + "..."

    def item_pubdate(self, item):
        return item.posted_date

    def item_link(self, item):
        return item.get_absolute_url()
