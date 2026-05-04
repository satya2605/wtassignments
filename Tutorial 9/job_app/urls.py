from django.urls import path
from . import views
from .feeds import LatestJobsFeed

urlpatterns = [
    path('', views.JobListView.as_view(), name='job_list'),
    path('job/<int:pk>/', views.JobDetailView.as_view(), name='job_detail'),
    path('feed/', LatestJobsFeed(), name='job_feed'),
]
