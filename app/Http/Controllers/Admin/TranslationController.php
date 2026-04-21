namespace App\Controller\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translation;

class TranslationController extends Controller
{
    public function store(Request $request)
    {
        $modelId = $request->model_id;
        $modelType = $request->model_type;
        $locale = $request->locale; // e.g., 'ms'

        foreach ($request->translations as $key => $value) {
            if (!empty($value)) {
                Translation::updateOrCreate(
                    [
                        'translationable_id' => $modelId,
                        'translationable_type' => $modelType,
                        'locale' => $locale,
                        'key' => $key,
                    ],
                    ['value' => $value]
                );
            }
        }

        return back()->with('success', 'Translations updated successfully!');
    }
}