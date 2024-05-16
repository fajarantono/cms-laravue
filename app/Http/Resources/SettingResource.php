<?php

namespace App\Http\Resources;


use App\Models\ThemeSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{

    public array $info;

    public function __construct($info)
    {
        parent::__construct($info);
        $this->info = $info;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'company_name'                        => $this->info['company_name'],
            'company_email'                       => $this->info['company_email'],
            'company_phone'                       => $this->info['company_phone'],
            'company_address'                     => $this->info['company_address'],
            'company_country_code'                => $this->info['company_country_code'],
            'site_default_branch'                 => $this->info['site_default_branch'],
            'site_default_language'               => $this->info['site_default_language'],
            'site_copyright'                      => $this->info['site_copyright'],
            'site_currency_position'              => $this->info['site_currency_position'],
            'site_digit_after_decimal_point'      => $this->info['site_digit_after_decimal_point'],
            'site_default_currency_symbol'        => $this->info['site_default_currency_symbol'],
            'site_phone_verification'             => $this->info['site_phone_verification'],
            'site_language_switch'                => $this->info['site_language_switch'],
            'site_online_payment_gateway'         => $this->info['site_online_payment_gateway'],
            'site_food_preparation_time'          => $this->info['site_food_preparation_time'],
            'theme_logo'                          => $this->themeImage('theme_logo')->logo,
            'theme_footer_logo'                   => $this->themeImage('theme_footer_logo')->footerLogo,
            'theme_favicon_logo'                  => $this->themeImage('theme_favicon_logo')->faviconLogo,
            'notification_audio'                   => asset('/audio/notification.mp3'),
            'image_cart'                          => asset('/images/cart/empty-cart.gif'),
            'image_confirm'                       => asset('/images/cart/confirm.gif'),
            'image_vag'                           => asset('/images/item-type/veg.png'),
            'image_non_vag'                       => asset('/images/item-type/non-veg.png'),
            'image_app_store'                     => asset('/images/store/app-store.png'),
            'image_play_store'                    => asset('/images/store/play-store.png'),
            'image_order_track'                   => asset('/images/order/track.png'),
            'image_order_placed'                  => asset('/images/order/placed.gif'),
            'image_order_complete'                => asset('/images/order/complete.gif'),
            'image_order_delivered'               => asset('/images/order/delivered.gif'),
            'image_order_preparing'               => asset('/images/order/preparing_order.gif'),
            'image_order_out_for_delivery'        => asset('/images/order/out_for_delivery.gif'),
            'image_order_rejected'                => asset('/images/order/rejected.gif'),
            'image_order_canceled'                => asset('/images/order/canceled.gif'),
            'image_order_returned'                => asset('/images/order/returned.gif'),
            'image_four_zero_four_page'           => asset('/images/accessible/404.gif'),
            'image_four_zero_three_page'          => asset('/images/accessible/403.gif'),
        ];
    }

    public function themeImage($key)
    {
        return ThemeSetting::where(['key' => $key])->first();
    }
}
