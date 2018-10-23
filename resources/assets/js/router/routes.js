export default ({ authGuard, guestGuard }) => [
  // { path: '/', name: 'welcome', component: require('~/pages/welcome.vue') },

  // Authenticated routes.
  ...authGuard([
    // Dashboard
    { path: '/', name: 'Dashboard', meta: { breadcrumb: true }, component: require('~/pages/Dashboard.vue') },
    // **** Catalog ****
    { path: '/catalog/category', 
      name: 'category/category', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/category',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Category',
          component: require('~/components/catalog/category/CategoryIndex.vue')
        },
        { path: 'form', name: 'CategoryForm', component: require('~/components/catalog/category/CategoryForm.vue') },
        { path: ':id', name: 'CategoryEdit', component: require('~/components/catalog/category/CategoryForm.vue'), props:true }
      ]
    },
    // Review
    { path: '/catalog/review', 
      name: 'catalog/review', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/review',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Review',
          component: require('~/components/catalog/review/ReviewIndex.vue')
        },
        { path: 'form', name: 'ReviewForm', component: require('~/components/catalog/review/ReviewForm.vue') },
        { path: ':id', name: 'ReviewEdit', component: require('~/components/catalog/review/ReviewForm.vue'), props:true }
      ]
    },
    // stock status
    { path: '/catalog/stock_status', 
      name: 'stock_status', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/stock_status',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Stock Status',
          component: require('~/components/catalog/stockStatus/StockStatusIndex.vue')
        },
        { path: 'form', name: 'StockStatusForm', component: require('~/components/catalog/stockStatus/StockStatusForm.vue') },
        { path: ':id', name: 'StockStatusEdit', component: require('~/components/catalog/stockStatus/StockStatusForm.vue'), props:true }
      ]
    },
    // Option
    { path: '/catalog/option', 
      name: 'catalog/option', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/option',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Option',
          component: require('~/components/catalog/option/OptionIndex.vue')
        },
        { path: 'form', name: 'OptionForm', component: require('~/components/catalog/option/OptionForm.vue') },
        { path: ':id', name: 'OptionEdit', component: require('~/components/catalog/option/OptionForm.vue'), props:true }
      ]
    },
    // Product
    { path: '/catalog/product', 
      name: 'catalog/product', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/product',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Product',
          component: require('~/components/catalog/product/ProductIndex.vue')
        },
        { path: 'form', name: 'ProductForm', component: require('~/components/catalog/product/ProductForm.vue') },
        { path: ':id', name: 'ProductEdit', component: require('~/components/catalog/product/ProductForm.vue'), props:true }
      ]
    },
    // Information
    { path: '/catalog/information', 
      name: 'catalog/information', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/information',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Information',
          component: require('~/components/catalog/information/InformationIndex.vue')
        },
        { path: 'form', name: 'InformationForm', component: require('~/components/catalog/information/InformationForm.vue') },
        { path: ':id', name: 'InformationEdit', component: require('~/components/catalog/information/InformationForm.vue'), props:true }
      ]
    },
    // attribute
    { path: '/catalog/attribute', 
      name: 'attribute', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/attribute',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Attribute',
          component: require('~/components/catalog/attribute/AttributeIndex.vue')
        },
        { path: 'form', name: 'AttributeForm', component: require('~/components/catalog/attribute/AttributeForm.vue') },
        { path: ':id', name: 'AttributeEdit', component: require('~/components/catalog/attribute/AttributeForm.vue'), props:true }
      ]
    },
    // attribute group
    { path: '/catalog/attribute_group', 
      name: 'attribute_group', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/attribute_group',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Attribute Group',
          component: require('~/components/catalog/attributeGroup/AttributeGroupIndex.vue')
        },
        { path: 'form', name: 'AttributeGroupForm', component: require('~/components/catalog/attributeGroup/AttributeGroupForm.vue') },
        { path: ':id', name: 'AttributeGroupEdit', component: require('~/components/catalog/attributeGroup/AttributeGroupForm.vue'), props:true }
      ]
    },
    // category type
    { path: '/catalog/category_type', 
      name: 'category_type', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/category_type',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Category Type',
          component: require('~/components/catalog/categoryType/CategoryTypeIndex.vue')
        },
        { path: 'form', name: 'CategoryTypeForm', component: require('~/components/catalog/categoryType/CategoryTypeForm.vue') },
        { path: ':id', name: 'CategoryTypeEdit', component: require('~/components/catalog/categoryType/CategoryTypeForm.vue'), props:true }
      ]
    },
    // currentcy rate
    { path: '/catalog/currency_rate', 
      name: 'currency_rate', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/currency_rate',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Currency Rate',
          component: require('~/components/catalog/currencyRate/CurrencyRateIndex.vue')
        },
        { path: 'form', name: 'CurrencyRateForm', component: require('~/components/catalog/currencyRate/CurrencyRateForm.vue') },
        { path: ':id', name: 'CurrencyRateEdit', component: require('~/components/catalog/currencyRate/CurrencyRateForm.vue'), props:true }
      ]
    },
    // filter
    { path: '/catalog/filter', 
      name: 'filter', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/filter',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Filters',
          component: require('~/components/catalog/filter/FilterIndex.vue')
        },
        { path: 'form', name: 'FilterForm', component: require('~/components/catalog/filter/FilterForm.vue') },
        { path: ':id', name: 'FilterEdit', component: require('~/components/catalog/filter/FilterForm.vue'), props:true }
      ]
    },
    // filter group
    { path: '/catalog/filter_group', 
      name: 'filter_group', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/filter_group',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Filters Group',
          component: require('~/components/catalog/filterGroup/FilterGroupIndex.vue')
        },
        { path: 'form', name: 'FilterGroupForm', component: require('~/components/catalog/filterGroup/FilterGroupForm.vue') },
        { path: ':id', name: 'FilterGroupEdit', component: require('~/components/catalog/filterGroup/FilterGroupForm.vue'), props:true }
      ]
    },
    // language
    { path: '/catalog/language', 
      name: 'language', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/language',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Language',
          component: require('~/components/catalog/language/LanguageIndex.vue')
        },
        { path: 'form', name: 'LanguageForm', component: require('~/components/catalog/language/LanguageForm.vue') },
        { path: ':id', name: 'LanguageEdit', component: require('~/components/catalog/language/LanguageForm.vue'), props:true }
      ]
    },
    // manufacturer
    { path: '/catalog/manufacturer', 
      name: 'manufacturer', 
      meta: { breadcrumb: true }, 
      redirect: '/catalog/manufacturer',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Manufacturer',
          component: require('~/components/catalog/manufacturer/ManufacturerIndex.vue')
        },
        { path: 'form', name: 'ManufacturerForm', component: require('~/components/catalog/manufacturer/ManufacturerForm.vue') },
        { path: ':id', name: 'ManufacturerEdit', component: require('~/components/catalog/manufacturer/ManufacturerForm.vue'), props:true }
      ]
    },

    // Geo Zone
    { path: '/system/geo_zone', 
      name: 'geo_zone', 
      meta: { breadcrumb: true }, 
      redirect: '/system/geo_zone',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'GEO Zone',
          component: require('~/components/system/geoZone/GeoZoneIndex.vue')
        },
        { path: 'form', name: 'GeoZoneForm', component: require('~/components/system/geoZone/GeoZoneForm.vue') },
        { path: ':id', name: 'GeoZoneEdit', component: require('~/components/system/geoZone/GeoZoneForm.vue'), props:true }
      ]
    },
    // Zone
    { path: '/system/zone', 
      name: 'zone', 
      meta: { breadcrumb: true }, 
      redirect: '/system/zone',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Zone',
          component: require('~/components/system/zone/ZoneIndex.vue')
        },
        { path: 'form', name: 'ZoneForm', component: require('~/components/system/zone/ZoneForm.vue') },
        { path: ':id', name: 'ZoneEdit', component: require('~/components/system/zone/ZoneForm.vue'), props:true }
      ]
    },
    // Country
    { path: '/system/country', 
      name: 'system/country', 
      meta: { breadcrumb: true }, 
      redirect: '/system/country',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Country',
          component: require('~/components/system/country/CountryIndex.vue')
        },
        { path: 'form', name: 'CountryForm', component: require('~/components/system/country/CountryForm.vue') },
        { path: ':id', name: 'CountryEdit', component: require('~/components/system/country/CountryForm.vue'), props:true }
      ]
    },
    // Credit Type
    { path: '/system/credit_type', 
      name: 'credit_type', 
      meta: { breadcrumb: true }, 
      redirect: '/system/credit_type',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Credit Type',
          component: require('~/components/system/creditType/CreditTypeIndex.vue')
        },
        { path: 'form', name: 'CreditTypeForm', component: require('~/components/system/creditType/CreditTypeForm.vue') },
        { path: ':id', name: 'CreditTypeEdit', component: require('~/components/system/creditType/CreditTypeForm.vue'), props:true }
      ]
    },
    // Credit Type Value
    { path: '/system/credit_type_value', 
      name: 'credit_type_value', 
      meta: { breadcrumb: true }, 
      redirect: '/system/credit_type_value',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Credit Type Value',
          component: require('~/components/system/creditTypeValue/CreditTypeValueIndex.vue')
        },
        { path: 'form', name: 'CreditTypeValueForm', component: require('~/components/system/creditTypeValue/CreditTypeValueForm.vue') },
        { path: ':id', name: 'CreditTypeValueEdit', component: require('~/components/system/creditTypeValue/CreditTypeValueForm.vue'), props:true }
      ]
    },
    // Tax Rate
    { path: '/system/tax_rate', 
      name: 'tax_rate', 
      meta: { breadcrumb: true }, 
      redirect: '/system/tax_rate',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Tax Rate',
          component: require('~/components/system/taxRate/TaxRateIndex.vue')
        },
        { path: 'form', name: 'TaxRateForm', component: require('~/components/system/taxRate/TaxRateForm.vue') },
        { path: ':id', name: 'TaxRateEdit', component: require('~/components/system/taxRate/TaxRateForm.vue'), props:true }
      ]
    },
    // Tax Rate
    { path: '/system/tax_rule', 
      name: 'tax_rule', 
      meta: { breadcrumb: true }, 
      redirect: '/system/tax_rule',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Tax Rule',
          component: require('~/components/system/taxRule/TaxRuleIndex.vue')
        },
        { path: 'form', name: 'TaxRuleForm', component: require('~/components/system/taxRule/TaxRuleForm.vue') },
        { path: ':id', name: 'TaxRuleEdit', component: require('~/components/system/taxRule/TaxRuleForm.vue'), props:true }
      ]
    },
    // Order Status
    { path: '/system/order_status', 
      name: 'order_status', 
      meta: { breadcrumb: true }, 
      redirect: '/system/order_status',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Order Status',
          component: require('~/components/system/orderStatus/OrderStatusIndex.vue')
        },
        { path: 'form', name: 'OrderStatusForm', component: require('~/components/system/orderStatus/OrderStatusForm.vue') },
        { path: ':id', name: 'OrderStatusEdit', component: require('~/components/system/orderStatus/OrderStatusForm.vue'), props:true }
      ]
    },
    // Payment Configuration
    { path: '/payment/payment_method', 
      name: 'payment/payment_method', 
      meta: { breadcrumb: true }, 
      redirect: '/payment/payment_method',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Payment Methods',
          component: require('~/components/payment/PaymentIndex.vue')
        },
        { path: 'form', name: 'PaymentConfigurationForm', component: require('~/components/payment/PaymentConfigurationForm.vue') },
        { path: ':id', name: 'PaymentConfigurationEdit', component: require('~/components/payment/PaymentConfigurationForm.vue'), props:true }
      ]
    },
    // Store Configuration
    { path: '/system/store_configuration', 
      name: 'system/store_configuration', 
      meta: { breadcrumb: true }, 
      redirect: '/system/store_configuration',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Store Configuration',
          component: require('~/components/system/storeConfiguration/StoreConfigurationIndex.vue')
        },
        { path: 'form', name: 'StoreConfigurationForm', component: require('~/components/system/storeConfiguration/StoreConfigurationForm.vue') },
        { path: ':id', name: 'StoreConfigurationEdit', component: require('~/components/system/storeConfiguration/StoreConfigurationForm.vue'), props:true }
      ]
    },
    // Tax Class
    { path: '/system/tax_class', 
      name: 'tax_class', 
      meta: { breadcrumb: true }, 
      redirect: '/system/tax_class',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Tax Class',
          component: require('~/components/system/taxClass/TaxClassIndex.vue')
        },
        { path: 'form', name: 'TaxClassForm', component: require('~/components/system/taxClass/TaxClassForm.vue') },
        { path: ':id', name: 'TaxClassEdit', component: require('~/components/system/taxClass/TaxClassForm.vue'), props:true }
      ]
    },
    // Weight Class
    { path: '/system/weight_class', 
      name: 'weight_class', 
      meta: { breadcrumb: true }, 
      redirect: '/system/weight_class',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Weight Class',
          component: require('~/components/system/weightClass/WeightClassIndex.vue')
        },
        { path: 'form', name: 'WeightClassForm', component: require('~/components/system/weightClass/WeightClassForm.vue') },
        { path: ':id', name: 'WeightClassEdit', component: require('~/components/system/weightClass/WeightClassForm.vue'), props:true }
      ]
    },

    // Length Class
    { path: '/system/length_class', 
      name: 'system/length_class', 
      meta: { breadcrumb: true }, 
      redirect: '/system/length_class',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Length Class',
          component: require('~/components/system/lengthClass/LengthClassIndex.vue')
        },
        { path: 'form', name: 'LengthClassForm', component: require('~/components/system/lengthClass/LengthClassForm.vue') },
        { path: ':id', name: 'LengthClassEdit', component: require('~/components/system/lengthClass/LengthClassForm.vue'), props:true }
      ]
    },

    // Customer
    { path: '/customer/customer', 
      name: 'customer/customer', 
      meta: { breadcrumb: true }, 
      redirect: '/customer/customer',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Customer',
          component: require('~/components/customer/customer/CustomerIndex.vue')
        },
        { path: 'form', name: 'CustomerForm', component: require('~/components/customer/customer/CustomerForm.vue') },
        { path: ':id', name: 'CustomerEdit', component: require('~/components/customer/customer/CustomerForm.vue'), props:true }
      ]
    },

    // Customer Group
    { path: '/customer/customer_group', 
      name: 'customer/customer_group', 
      meta: { breadcrumb: true }, 
      redirect: '/customer/customer_group',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Customer Group',
          component: require('~/components/customer/customerGroup/CustomerGroupIndex.vue')
        },
        { path: 'form', name: 'CustomerGroupForm', component: require('~/components/customer/customerGroup/CustomerGroupForm.vue') },
        { path: ':id', name: 'CustomerGroupEdit', component: require('~/components/customer/customerGroup/CustomerGroupForm.vue'), props:true }
      ]
    },

    // User
    { path: '/user/user', 
      name: 'user/user', 
      meta: { breadcrumb: true }, 
      redirect: '/user/user',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Users',
          component: require('~/components/user/user/UserIndex.vue')
        },
        { path: 'form', name: 'UserForm', component: require('~/components/user/user/UserForm.vue') },
        { path: ':id', name: 'UserEdit', component: require('~/components/user/user/UserForm.vue'), props:true }
      ]
    },
    // User Group
    { path: '/user/user_group', 
      name: 'user/user_group', 
      meta: { breadcrumb: true }, 
      redirect: '/user/user_group',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'User Groups',
          component: require('~/components/user/Group/UserGroupIndex.vue')
        },
        { path: 'form', name: 'UserGroupForm', component: require('~/components/user/Group/UserGroupForm.vue') },
        { path: ':id', name: 'UserGroupEdit', component: require('~/components/user/Group/UserGroupForm.vue'), props:true },
        { path: 'role/:id', name: 'UserRoleEdit', component: require('~/components/user/userRole/UserRoleForm.vue'), props:true }
      ]
    },
    // Supplier
    { path: '/supplier/suppliers', 
      name: 'supplier/suppliers', 
      meta: { breadcrumb: true }, 
      redirect: '/supplier/suppliers',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Suppliers',
          component: require('~/components/supplier/SupplierIndex.vue')
        },
        { path: 'form', name: 'SupplierForm', component: require('~/components/supplier/SupplierForm.vue') },
        { path: ':id', name: 'SupplierEdit', component: require('~/components/supplier/SupplierForm.vue'), props:true }
      ]
    },
    // Reseller
    { path: '/reseller/reseller', 
      name: 'reseller/reseller', 
      meta: { breadcrumb: true }, 
      redirect: '/reseller/reseller',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Resellers List',
          component: require('~/components/reseller/ResellerIndex.vue')
        },
        { path: 'form', name: 'ResellerForm', component: require('~/components/reseller/ResellerForm.vue') },
        { path: ':id', name: 'ResellerEdit', component: require('~/components/reseller/ResellerForm.vue'), props:true }
      ]
    },
    // Shipping
    { path: '/shipping/carrier', 
      name: 'shipping/carrier', 
      meta: { breadcrumb: true }, 
      redirect: '/shipping/carrier',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Carriers',
          component: require('~/components/shipping/carrier/CarrierIndex.vue')
        },
        { path: 'form', name: 'CarrierForm', component: require('~/components/shipping/carrier/CarrierForm.vue') },
        { path: ':id', name: 'CarrierEdit', component: require('~/components/shipping/carrier/CarrierForm.vue'), props:true }
      ]
    },

    // Sale Order
    { path: '/sale_order/order', 
      name: 'sale_order/order', 
      meta: { breadcrumb: true }, 
      redirect: '/sale_order/order',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '',
          meta: { breadcrumb: true },
          name: 'Sale Orders',
          component: require('~/components/saleOrder/OrderIndex.vue')
        },
        { path: 'form', name: 'SaleOrderForm', component: require('~/components/saleOrder/OrderForm.vue') },
        { path: ':id', name: 'SaleOrderEdit', component: require('~/components/saleOrder/OrderForm.vue'), props:true }
      ]
    },

  ]),

  // Guest routes.
  ...guestGuard([
    { path: '/login', name: 'login', component: require('~/pages/auth/login.vue') },
    { path: '/register', name: 'register', component: require('~/pages/auth/register.vue') },
    { path: '/password/reset', name: 'password.request', component: require('~/pages/auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: require('~/pages/auth/password/reset.vue') }
  ]),
  {
    path: '*',
    meta: {
      public: true,
    },
    component: require('~/pages/errors/404.vue')
  }
  // { path: '*', component: require('~/pages/errors/404.vue') }
]
