from django.db import models

class Comment(models.Model):
    username = models.CharField(max_length=100)
    comment_text = models.TextField()
    created_date = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"Comment by {self.username}"
