<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('product')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.questions.index', compact('questions'));
    }

    public function show($id)
    {
        $question = Question::with('product')->findOrFail($id);

        // Mark as read if not already read
        if (!$question->is_read) {
            $question->update(['is_read' => true]);
        }

        return view('admin.questions.show', compact('question'));
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question deleted successfully.');
    }

    public function markAsRead($id)
    {
        $question = Question::findOrFail($id);
        $question->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAsUnread($id)
    {
        $question = Question::findOrFail($id);
        $question->update(['is_read' => false]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question marked as unread.');
    }
}
