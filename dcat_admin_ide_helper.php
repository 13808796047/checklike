<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection roles
     * @property Grid\Column|Collection permissions
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection user
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection price_type
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection agent_price1
     * @property Grid\Column|Collection agent_price2
     * @property Grid\Column|Collection check_type
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection nick_name
     * @property Grid\Column|Collection consumption_amount
     * @property Grid\Column|Collection inviter
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection content_before
     * @property Grid\Column|Collection content_after
     * @property Grid\Column|Collection cid
     * @property Grid\Column|Collection classid
     * @property Grid\Column|Collection classname
     * @property Grid\Column|Collection sname
     * @property Grid\Column|Collection min_words
     * @property Grid\Column|Collection max_words
     * @property Grid\Column|Collection intro
     * @property Grid\Column|Collection sintro
     * @property Grid\Column|Collection tese
     * @property Grid\Column|Collection seo_title
     * @property Grid\Column|Collection sys_logo
     * @property Grid\Column|Collection sys_ico
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection real_path
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection orderid
     * @property Grid\Column|Collection userid
     * @property Grid\Column|Collection writer
     * @property Grid\Column|Collection date_publish
     * @property Grid\Column|Collection words
     * @property Grid\Column|Collection pay_price
     * @property Grid\Column|Collection pay_type
     * @property Grid\Column|Collection payid
     * @property Grid\Column|Collection date_pay
     * @property Grid\Column|Collection paper_path
     * @property Grid\Column|Collection report_path
     * @property Grid\Column|Collection rate
     * @property Grid\Column|Collection result
     * @property Grid\Column|Collection from
     * @property Grid\Column|Collection keyword
     * @property Grid\Column|Collection rid
     * @property Grid\Column|Collection del
     * @property Grid\Column|Collection api_orderid
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection report_pdf_path
     * @property Grid\Column|Collection endDate
     * @property Grid\Column|Collection publishdate
     * @property Grid\Column|Collection referer
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection no
     * @property Grid\Column|Collection total_amount
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection paid_at
     * @property Grid\Column|Collection payment_method
     * @property Grid\Column|Collection payment_no
     * @property Grid\Column|Collection refund_status
     * @property Grid\Column|Collection refund_no
     * @property Grid\Column|Collection closed
     * @property Grid\Column|Collection reviewed
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection weixin_openid
     * @property Grid\Column|Collection weapp_openid
     * @property Grid\Column|Collection weixin_session_key
     * @property Grid\Column|Collection weixin_unionid
     * @property Grid\Column|Collection user_group
     * @property Grid\Column|Collection redix
     * @property Grid\Column|Collection weapp_unionid
     * @property Grid\Column|Collection jc_times
     * @property Grid\Column|Collection subscribe
     * @property Grid\Column|Collection subscribe_time
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection roles(string $label = null)
     * @method Grid\Column|Collection permissions(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection user(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection price_type(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection agent_price1(string $label = null)
     * @method Grid\Column|Collection agent_price2(string $label = null)
     * @method Grid\Column|Collection check_type(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection nick_name(string $label = null)
     * @method Grid\Column|Collection consumption_amount(string $label = null)
     * @method Grid\Column|Collection inviter(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection content_before(string $label = null)
     * @method Grid\Column|Collection content_after(string $label = null)
     * @method Grid\Column|Collection cid(string $label = null)
     * @method Grid\Column|Collection classid(string $label = null)
     * @method Grid\Column|Collection classname(string $label = null)
     * @method Grid\Column|Collection sname(string $label = null)
     * @method Grid\Column|Collection min_words(string $label = null)
     * @method Grid\Column|Collection max_words(string $label = null)
     * @method Grid\Column|Collection intro(string $label = null)
     * @method Grid\Column|Collection sintro(string $label = null)
     * @method Grid\Column|Collection tese(string $label = null)
     * @method Grid\Column|Collection seo_title(string $label = null)
     * @method Grid\Column|Collection sys_logo(string $label = null)
     * @method Grid\Column|Collection sys_ico(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection real_path(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection orderid(string $label = null)
     * @method Grid\Column|Collection userid(string $label = null)
     * @method Grid\Column|Collection writer(string $label = null)
     * @method Grid\Column|Collection date_publish(string $label = null)
     * @method Grid\Column|Collection words(string $label = null)
     * @method Grid\Column|Collection pay_price(string $label = null)
     * @method Grid\Column|Collection pay_type(string $label = null)
     * @method Grid\Column|Collection payid(string $label = null)
     * @method Grid\Column|Collection date_pay(string $label = null)
     * @method Grid\Column|Collection paper_path(string $label = null)
     * @method Grid\Column|Collection report_path(string $label = null)
     * @method Grid\Column|Collection rate(string $label = null)
     * @method Grid\Column|Collection result(string $label = null)
     * @method Grid\Column|Collection from(string $label = null)
     * @method Grid\Column|Collection keyword(string $label = null)
     * @method Grid\Column|Collection rid(string $label = null)
     * @method Grid\Column|Collection del(string $label = null)
     * @method Grid\Column|Collection api_orderid(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection report_pdf_path(string $label = null)
     * @method Grid\Column|Collection endDate(string $label = null)
     * @method Grid\Column|Collection publishdate(string $label = null)
     * @method Grid\Column|Collection referer(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection no(string $label = null)
     * @method Grid\Column|Collection total_amount(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection paid_at(string $label = null)
     * @method Grid\Column|Collection payment_method(string $label = null)
     * @method Grid\Column|Collection payment_no(string $label = null)
     * @method Grid\Column|Collection refund_status(string $label = null)
     * @method Grid\Column|Collection refund_no(string $label = null)
     * @method Grid\Column|Collection closed(string $label = null)
     * @method Grid\Column|Collection reviewed(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection weixin_openid(string $label = null)
     * @method Grid\Column|Collection weapp_openid(string $label = null)
     * @method Grid\Column|Collection weixin_session_key(string $label = null)
     * @method Grid\Column|Collection weixin_unionid(string $label = null)
     * @method Grid\Column|Collection user_group(string $label = null)
     * @method Grid\Column|Collection redix(string $label = null)
     * @method Grid\Column|Collection weapp_unionid(string $label = null)
     * @method Grid\Column|Collection jc_times(string $label = null)
     * @method Grid\Column|Collection subscribe(string $label = null)
     * @method Grid\Column|Collection subscribe_time(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection name
     * @property Show\Field|Collection roles
     * @property Show\Field|Collection permissions
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection user
     * @property Show\Field|Collection method
     * @property Show\Field|Collection path
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection price_type
     * @property Show\Field|Collection price
     * @property Show\Field|Collection agent_price1
     * @property Show\Field|Collection agent_price2
     * @property Show\Field|Collection check_type
     * @property Show\Field|Collection status
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection nick_name
     * @property Show\Field|Collection consumption_amount
     * @property Show\Field|Collection inviter
     * @property Show\Field|Collection type
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection content_before
     * @property Show\Field|Collection content_after
     * @property Show\Field|Collection cid
     * @property Show\Field|Collection classid
     * @property Show\Field|Collection classname
     * @property Show\Field|Collection sname
     * @property Show\Field|Collection min_words
     * @property Show\Field|Collection max_words
     * @property Show\Field|Collection intro
     * @property Show\Field|Collection sintro
     * @property Show\Field|Collection tese
     * @property Show\Field|Collection seo_title
     * @property Show\Field|Collection sys_logo
     * @property Show\Field|Collection sys_ico
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection real_path
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection content
     * @property Show\Field|Collection orderid
     * @property Show\Field|Collection userid
     * @property Show\Field|Collection writer
     * @property Show\Field|Collection date_publish
     * @property Show\Field|Collection words
     * @property Show\Field|Collection pay_price
     * @property Show\Field|Collection pay_type
     * @property Show\Field|Collection payid
     * @property Show\Field|Collection date_pay
     * @property Show\Field|Collection paper_path
     * @property Show\Field|Collection report_path
     * @property Show\Field|Collection rate
     * @property Show\Field|Collection result
     * @property Show\Field|Collection from
     * @property Show\Field|Collection keyword
     * @property Show\Field|Collection rid
     * @property Show\Field|Collection del
     * @property Show\Field|Collection api_orderid
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection report_pdf_path
     * @property Show\Field|Collection endDate
     * @property Show\Field|Collection publishdate
     * @property Show\Field|Collection referer
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection no
     * @property Show\Field|Collection total_amount
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection paid_at
     * @property Show\Field|Collection payment_method
     * @property Show\Field|Collection payment_no
     * @property Show\Field|Collection refund_status
     * @property Show\Field|Collection refund_no
     * @property Show\Field|Collection closed
     * @property Show\Field|Collection reviewed
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection weixin_openid
     * @property Show\Field|Collection weapp_openid
     * @property Show\Field|Collection weixin_session_key
     * @property Show\Field|Collection weixin_unionid
     * @property Show\Field|Collection user_group
     * @property Show\Field|Collection redix
     * @property Show\Field|Collection weapp_unionid
     * @property Show\Field|Collection jc_times
     * @property Show\Field|Collection subscribe
     * @property Show\Field|Collection subscribe_time
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection roles(string $label = null)
     * @method Show\Field|Collection permissions(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection user(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection price_type(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection agent_price1(string $label = null)
     * @method Show\Field|Collection agent_price2(string $label = null)
     * @method Show\Field|Collection check_type(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection nick_name(string $label = null)
     * @method Show\Field|Collection consumption_amount(string $label = null)
     * @method Show\Field|Collection inviter(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection content_before(string $label = null)
     * @method Show\Field|Collection content_after(string $label = null)
     * @method Show\Field|Collection cid(string $label = null)
     * @method Show\Field|Collection classid(string $label = null)
     * @method Show\Field|Collection classname(string $label = null)
     * @method Show\Field|Collection sname(string $label = null)
     * @method Show\Field|Collection min_words(string $label = null)
     * @method Show\Field|Collection max_words(string $label = null)
     * @method Show\Field|Collection intro(string $label = null)
     * @method Show\Field|Collection sintro(string $label = null)
     * @method Show\Field|Collection tese(string $label = null)
     * @method Show\Field|Collection seo_title(string $label = null)
     * @method Show\Field|Collection sys_logo(string $label = null)
     * @method Show\Field|Collection sys_ico(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection real_path(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection orderid(string $label = null)
     * @method Show\Field|Collection userid(string $label = null)
     * @method Show\Field|Collection writer(string $label = null)
     * @method Show\Field|Collection date_publish(string $label = null)
     * @method Show\Field|Collection words(string $label = null)
     * @method Show\Field|Collection pay_price(string $label = null)
     * @method Show\Field|Collection pay_type(string $label = null)
     * @method Show\Field|Collection payid(string $label = null)
     * @method Show\Field|Collection date_pay(string $label = null)
     * @method Show\Field|Collection paper_path(string $label = null)
     * @method Show\Field|Collection report_path(string $label = null)
     * @method Show\Field|Collection rate(string $label = null)
     * @method Show\Field|Collection result(string $label = null)
     * @method Show\Field|Collection from(string $label = null)
     * @method Show\Field|Collection keyword(string $label = null)
     * @method Show\Field|Collection rid(string $label = null)
     * @method Show\Field|Collection del(string $label = null)
     * @method Show\Field|Collection api_orderid(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection report_pdf_path(string $label = null)
     * @method Show\Field|Collection endDate(string $label = null)
     * @method Show\Field|Collection publishdate(string $label = null)
     * @method Show\Field|Collection referer(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection no(string $label = null)
     * @method Show\Field|Collection total_amount(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection paid_at(string $label = null)
     * @method Show\Field|Collection payment_method(string $label = null)
     * @method Show\Field|Collection payment_no(string $label = null)
     * @method Show\Field|Collection refund_status(string $label = null)
     * @method Show\Field|Collection refund_no(string $label = null)
     * @method Show\Field|Collection closed(string $label = null)
     * @method Show\Field|Collection reviewed(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection weixin_openid(string $label = null)
     * @method Show\Field|Collection weapp_openid(string $label = null)
     * @method Show\Field|Collection weixin_session_key(string $label = null)
     * @method Show\Field|Collection weixin_unionid(string $label = null)
     * @method Show\Field|Collection user_group(string $label = null)
     * @method Show\Field|Collection redix(string $label = null)
     * @method Show\Field|Collection weapp_unionid(string $label = null)
     * @method Show\Field|Collection jc_times(string $label = null)
     * @method Show\Field|Collection subscribe(string $label = null)
     * @method Show\Field|Collection subscribe_time(string $label = null)
     */
    class Show {}

    /**
     * @method \Dcat\Admin\Form\Field\Button button(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
