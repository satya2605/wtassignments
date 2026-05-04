from django.urls import path
from . import views
from .feeds import LatestEntriesFeed

urlpatterns = [
    path('', views.BlogListView.as_view(), name='blog_list'),
    path('post/<int:pk>/', views.BlogDetailView.as_view(), name='blog_detail'),
    path('feed/', LatestEntriesFeed(), name='blog_feed'),
]
