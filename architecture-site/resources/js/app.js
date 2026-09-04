import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.data('nav',()=>({open:false}));
Alpine.data('lightbox', (items=[])=>({items,index:0,open:false,show(i){this.index=i;this.open=true},next(){this.index=(this.index+1)%this.items.length},prev(){this.index=(this.index-1+this.items.length)%this.items.length}}));
Alpine.data('readingProgress',()=>({progress:0,update(){const d=document.documentElement;this.progress=(d.scrollTop/(d.scrollHeight-d.clientHeight))*100}}));
Alpine.start();
