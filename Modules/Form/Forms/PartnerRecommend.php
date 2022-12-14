<?php


namespace Modules\Form\Forms;


use Carbon\Carbon;

class PartnerRecommend extends Form
{
    public function title(): string
    {
        return 'Рекомендация';
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'recommend_name' => 'required|string|max:255',
            'recommend_phone' => 'required|string|phone_default_countries|max:255',
            'recommend_email' => 'required|string|email|max:255',
            'comment' => 'required|string|max:1024',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'company' => 'Название компании',
            'city' => 'Город',
            'name' => 'ФИО контактного лица',
            'post' => 'Должность',
            'recommend_name' => 'ФИО рекомендующего',
            'recommend_phone' => 'Телефон рекомендующего',
            'recommend_email' => 'email рекомендующего',
            'comment' => 'Комментарий',
        ];
    }

    public function getComments(): string
    {
        $company = $this->getAttribute('company');
        $city = $this->getAttribute('city');
        $name = $this->getAttribute('name') ?? $this->getAuthName();
        $post = $this->getAttribute('post');

        $recommend_name = $this->getAttribute('recommend_name');
        $recommend_phone = $this->getAttribute('recommend_phone');
        $recommend_email = $this->getAttribute('recommend_email');
        $comment = $this->getAttribute('comment');

        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $url = url()->previous();

        return "
                <b>Получена заявка:</b> $date
                <br><b>Форма:</b> {$this->title()}
                <br><b>Страница:</b> $url
                <br><b>Данные рекомендуемой компании:</b>
                <br><b>Компания:</b> $company
                <br><b>Город:</b> $city
                <br><b>ФИО лица, принимающего решения:</b> $name
                <br><b>Должность:</b> $post
                <br><b>Телефон:</b> {$this->getAuthPhone()}
                <br><b>Email:</b> {$this->getAuthEmail()}
                <br><b>Ваши контактные данные:</b>
                <br><b>ФИО:</b> $recommend_name
                <br><b>Телефон:</b> $recommend_phone
                <br><b>Email:</b> $recommend_email
                <br><b>Комментарий:</b> $comment
                ";
    }
}
