from django.db import models
from django.urls import reverse

class Job(models.Model):
    job_title = models.CharField(max_length=200)
    company_name = models.CharField(max_length=100)
    location = models.CharField(max_length=100)
    description = models.TextField()
    posted_date = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"{self.job_title} at {self.company_name}"

    def get_absolute_url(self):
        return reverse('job_detail', args=[str(self.id)])
