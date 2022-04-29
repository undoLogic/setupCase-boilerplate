const app = Vue.createApp({
data() {
    return {
        showBooks: true,
        title: 'Test Title',
        author: 'Test Author',
        age: 45
    }
},
    methods:{
        toggleShowBooks() {
       this.showBooks = !this.showBooks
   }
    }
})// end of component
app.mount("#app")
