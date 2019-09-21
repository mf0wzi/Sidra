<?php

namespace App\Http\Controllers;

use App\Noonenew\Marker\Marker;
use Illuminate\Http\Request;
use App\Projectpage;
use Illuminate\Support\Arr;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Str;

class ProjectpagesController extends Controller
{
    public function builder($id)
    {

        $projectpage = new Projectpage();
        $projectpage = $projectpage->findOrFail($id);


        $this->authorize('edit', $projectpage);

        $isModelTranslatable = is_bread_translatable(Marker::model('PageItem'));

        return Voyager::view('vendor.voyager.projectpages.builder', compact('projectpage', 'isModelTranslatable'));
    }

    public function delete_menu($menu, $id)
    {
        $item = Marker::model('PageItem')->findOrFail($id);

        $this->authorize('delete', $item);

        $item->deleteAttributeTranslation('title');

        $item->destroy($id);

        return redirect()
            ->route('projectpages.builder', [$menu])
            ->with([
                'message'    => __('Successfully Deleted Item'),
                'alert-type' => 'success',
            ]);
    }

    public function add_item(Request $request)
    {
        $menu = Marker::model('ProjectPage');


        $this->authorize('add', $menu);

        $data = $this->prepareParameters(
            $request->all()
        );

        unset($data['id'],$data['col_xs'],$data['col_sm'],$data['col_md'],$data['col_lg']);
        $data['order'] = Marker::model('PageItem')->highestOrderMenuItem();
        $data['item_id'] = (string) Str::uuid();

        // Check if is translatable
        $_isTranslatable = is_bread_translatable(Marker::model('PageItem'));
        if ($_isTranslatable) {
            // Prepare data before saving the menu
            $trans = $this->prepareMenuTranslations($data);
        }

        $menuItem = Marker::model('PageItem')->create($data);

        // Save menu translations
        if ($_isTranslatable) {
            $menuItem->setAttributeTranslations('title', $trans, true);
        }

        return redirect()
            ->route('projectpages.builder', [$data['projectpage_id']])
            ->with([
                'message'    => __('Successfully Created Item'),
                'alert-type' => 'success',
            ]);
    }

    public function update_item(Request $request)
    {
        $id = $request->input('id');
        $data = $this->prepareParameters(
            $request->except(['id'])
        );

        $menuItem = Marker::model('PageItem')->findOrFail($id);

        $this->authorize('edit', $menuItem->projectpage);

        if (is_bread_translatable($menuItem)) {
            $trans = $this->prepareMenuTranslations($data);

            // Save menu translations
            $menuItem->setAttributeTranslations('title', $trans, true);
        }
        unset($data['col_xs'],$data['col_sm'],$data['col_md'],$data['col_lg']);
        $menuItem->update($data);

        return redirect()
            ->route('projectpages.builder', [$menuItem->projectpage_id])
            ->with([
                'message'    => __('Successfully Updated Item'),
                'alert-type' => 'success',
            ]);
    }

    public function order_item(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));

        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = Marker::model('PageItem')->findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }

    protected function prepareParameters($parameters)
    {
        switch (Arr::get($parameters, 'type')) {
            case 'tab':
                $parameters['url'] = null;
                $parameters['route'] = null;
                $parameters['description'] = null;
                $parameters['parameters'] = 0;
                break;
            case 'row':
                $parameters['url'] = null;
                $parameters['route'] = null;
                $parameters['description'] = null;
                $parameters['parameters'] = 0;
                break;
            case 'col':
                $parameters['url'] = null;
                $parameters['route'] = null;
                $parameters['description'] = null;
                $parameters['parameters'] = 0;
                break;
            default:
                $parameters['route'] = null;
                $parameters['parameters'] = 0;
                break;
        }

//        if (isset($parameters['type'])) {
//            unset($parameters['type']);
//        }

        return $parameters;
    }

    /**
     * Prepare menu translations.
     *
     * @param array $data menu data
     *
     * @return JSON translated item
     */
    protected function prepareMenuTranslations(&$data)
    {
        $trans = json_decode($data['title_i18n'], true);

        // Set field value with the default locale
        $data['title'] = $trans[config('voyager.multilingual.default', 'en')];

        unset($data['title_i18n']);     // Remove hidden input holding translations
        unset($data['i18n_selector']);  // Remove language selector input radio

        return $trans;
    }
    //
}
