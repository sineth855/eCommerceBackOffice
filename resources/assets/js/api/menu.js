const Menu =  [
  { header: 'Apps' },
  {
    title: 'Dashboard',
    group: 'apps',
    icon: 'dashboard',
    name: 'Dashboard',
  },
  {
    title: 'Catalog',
    group: 'apps',
    icon: 'chat_bubble',
    target: '_blank',
    name: 'Chat',
    items: [
      { name: 'Category', title: 'Category', component: 'Category' },
      { name: 'Product', title: 'Product', component: 'Product' },
      // { name: 'Download', title: 'Download', component: 'Download' },      
      { name: 'Manufacturer', title: 'Manufacturer', component: 'Manufacturer' },
      { name: 'Language', title: 'Language', component: 'Language' },
      { name: 'Information', title: 'Information', component: 'Information' },
      { name: 'Filter Groups', title: 'Filter Groups', badge: 'new', component: 'Filters Group' },
      { name: 'Filters', title: 'Filters', component: 'Filters' },
      { name: 'Currency Rates', title: 'Currency Rates', component: 'Currency Rate' },
      { name: 'Option', title: 'Option', component: 'Option' },
      { name: 'Stock Status', title: 'Stock Status', component: 'Stock Status' },
      { name: 'Attribute Groups', title: 'Attribute Groups', component: 'Attribute Group' },
      { name: 'Review', title: 'Review', component: 'Review' },
      { name: 'Attribute', title: 'Attribute', component: 'Attribute' }
      // { name: 'Category Type', title: 'Category Type', component: 'Category Type' }
    ]
  },
  {
    title: 'Suppliers',
    group: 'apps',
    name: 'Suppliers',
    // target: '_blank',
    icon: 'person',
  },
  {
    title: 'Customer',
    group: 'apps',
    icon: 'people',
    target: '_blank',
    name: 'Customer',
    items: [
      { name: 'Customer', title: 'Customer', component: 'Customer' },
      { name: 'Customer Group', title: 'Customer Group', component: 'Customer Group' },
      // { name: 'Customer Field', title: 'Customer Field', component: 'Customer Field' }
    ]
  },
  {
    title: 'Sales',
    group: 'apps',
    name: 'Media',
    icon: 'shopping_cart',
    items: [
      { name: 'Sale Orders', title: 'Orders', component: 'Sale Orders' },
      // { name: 'Return', title: 'Return', badge: 'new', component: 'Return' }
    ]
  },
  {
    title: 'Payment',
    group: 'apps',
    name: 'Media',
    icon: 'credit_card',
    items: [
      { name: 'Payment Methods', title: 'Payment Methods', component: 'Payment Methods' },
      // { name: 'Preferences', title: 'Preferences', component: 'Preferences' }
    ]
  },
  {
    title: 'Resellers',
    group: 'widgets',
    component: 'widgets',
    icon: 'widgets',
    items: [
      { name: 'Resellers List', title: 'Resellers List', component: 'Resellers List' }
    ]
  },  
  // { header: 'UI Elements' },
  // {
  //   title: 'Tools',
  //   group: 'components',
  //   component: 'components',
  //   icon: 'tune',
  //   items: [
  //     { name: 'Backup & Restore', title: 'Backup & Restore', component: 'Backup & Restore' }
  //   ]
  // },
  // {
  //   title: 'Quotation',
  //   group: 'pickers',
  //   component: 'picker',
  //   icon: 'assignment',
  //   items: [
  //     { name: 'New Quotation', title: 'New Quotation', component: 'New Quotation' },     
  //     { name: 'Quotations', title: 'Quotations', component: 'Quotations' },      

  //   ]
  // },
  {
    title: 'Shipping',
    group: 'extra',
    icon: 'local_shipping',
    items: [
      { name: 'Carriers', title: 'Carriers', component: 'Carriers' }
      // { name: 'Undelivery Shipment', title: 'Undelivery Shipment', component: 'Undelivery Shipment' },
      // { name: 'Pickup List', title: 'Pickup List', component: 'Pickup List' },
    ]
  },
  // {
  //   title: 'Reports',
  //   group: 'layout',
  //   component: 'layout',
  //   icon: 'show_chart',
  //   items: [
  //     { name: 'Customer Orders', title: 'Customer Orders', component: 'Customer Orders' },
  //     { name: 'Return', title: 'Return', component: 'Return' },
  //     { name: 'Shipping', title: 'Shipping', component: 'Shipping' },
  //     { name: 'Orders', title: 'Orders', badge: 'new', component: 'Orders' }
  //   ]
  // },
  { divider: true },
  { header: 'Settings' },
  {
    title: 'Users',
    group: 'forms',
    component: 'forms',
    icon: 'people',
    items: [
      { name: 'Users', title: 'Users', component: 'Users' },
      { name: 'User Groups', title: 'User Groups', badge: 'new', component: 'User Groups' }
    ]
  },
  {
    title: 'Systems',
    group: 'extra',
    icon: 'settings',
    items: [
      { name: 'Store Configuration', title: 'Store Configuration', component: 'Store Configuration' },
      { name: 'GEO Zone', title: 'GEO Zone', component: 'GEO Zone' },
      { name: 'Zone', title: 'Zone', component: 'Zone' },
      { name: 'Country', title: 'Country', component: 'Country' },
      { name: 'Credit Type', title: 'Credit Type', component: 'Credit Type' },
      { name: 'Order Status', title: 'Order Status', component: 'Order Status' },
      { name: 'Tax Rule', title: 'Tax Rule', component: 'Tax Rule' },
      { name: 'Length Class', title: 'Length Class', component: 'Length Class' },
      { name: 'Weight Class', title: 'Weight Class', component: 'Weight Class' },
      { name: 'Tax Class', title: 'Tax Class', component: 'Tax Class' },      
      { name: 'Tax Rate', title: 'Tax Rate', component: 'Tax Rate' }
    ]
  },
];
// reorder menu
Menu.forEach((item) => {
  if (item.items) {
    item.items.sort((x, y) => {
      let textA = x.title.toUpperCase();
      let textB = y.title.toUpperCase();
      return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
    });
  }
});

export default Menu;
