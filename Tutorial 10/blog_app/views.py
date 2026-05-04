from django.shortcuts import render
from django.http import JsonResponse
from .models import Comment

def blog_page(request):
    comments = Comment.objects.all().order_by('-created_date')
    return render(request, 'blog_post.html', {'comments': comments})

def post_comment(request):
    if request.method == 'POST' and request.headers.get('x-requested-with') == 'XMLHttpRequest':
        username = request.POST.get('username')
        text = request.POST.get('comment_text')
        
        if username and text:
            # Create the comment
            comment = Comment.objects.create(username=username, comment_text=text)
            
            # Return JSON response with the new comment data
            return JsonResponse({
                'success': True,
                'username': comment.username,
                'text': comment.comment_text,
                'date': comment.created_date.strftime("%B %d, %Y, %I:%M %p")
            })
        
    return JsonResponse({'success': False, 'error': 'Invalid request'}, status=400)
