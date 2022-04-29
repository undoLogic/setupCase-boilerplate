<h1>Hello Vue</h1>
<div id="app">
    <div v-if="showBooks">
        <p>Title:{{title}} - Author: {{author}} - Age: {{age}}</p>
    </div>
    <div>
        <button @click="toggleShowBooks">
            <span v-if="showBooks">Hide Books</span>
            <span v-else> Show Books</span>
        </button>
    </div>
</div><!-- /#app -->
