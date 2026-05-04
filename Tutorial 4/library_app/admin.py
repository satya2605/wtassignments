from django.contrib import admin
from .models import Book

@admin.register(Book)
class BookAdmin(admin.ModelAdmin):
    # Customize the columns shown in the admin list view
    list_display = ('book_id', 'title', 'author', 'price')
    
    # Add a search bar for title and author
    search_fields = ('title', 'author')
    
    # Add filters for author
    list_filter = ('author',)
