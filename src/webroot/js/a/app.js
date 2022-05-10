const app = Vue.createApp({
data() {
    return {
        url: "https://www.undologic.com/eng/pages/home",
        img: '/src/webroot/assets/img/umbrella.jpg',
        alt: 'umbrella',
        showBooks: true,
        title: 'Test Title',
        author: 'Test Author',
        isActive: true,

        age: 45,
        books: [
            {title: 'Name of the wind', author: 'Patrick Rothfuss'},
            {title: 'The way of kings', author: 'Brandon Sanderson'},
            {title: 'The final empire', author: 'Brandon Sanderson'},
        ]
    }
},
    methods:{
        toggleShowBooks() {
       this.showBooks = !this.showBooks
   }
    }
})// end of component
app.mount("#app")
