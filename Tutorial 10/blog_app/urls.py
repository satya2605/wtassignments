from django.urls import path
from . import views

urlpatterns = [
    path('', views.blog_page, name='blog_page'),
    path('post-comment/', views.post_comment, name='post_comment'),
]
