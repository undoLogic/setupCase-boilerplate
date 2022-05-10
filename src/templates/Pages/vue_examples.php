<div id="app">
     <div class="card m-l-5">
            <div class="card-header">
                <h4>Vue Tutorial</h4>
            </div>
            <div class="row">
                <div  class="col-lg-6">
                    <!-- ************************** v-if, v-else and v-event ************************* -->
                    <div class="card-body ">
            <h5>v-if, v-else &  v-events</h5>
        <!-- v-if, v-event -->
        <div v-if="showBooks">
            <p>Title:{{title}} - Author: {{author}} - Age: {{age}}</p>
        </div>
        <div>
            <button @click="toggleShowBooks">
                <span v-if="showBooks">Hide Books</span>
                <span v-else> Show Books</span>
            </button>
        </div>

        </div><!-- card-body 1 -->
                </div>
                <div  class="col-lg-6">
                    <!-- ************************* v-for ************************** -->
                     <!-- loop - v-for -->
                    <div class="card-body">
                        <h5>v-for</h5>
                    <div >
                     <ul>
                    <li v-for = 'book in books'>
                        <h6>{{book.title}}</h6>
                        <p>{{book.author}}</p>
                    </li>
                </ul>

            </div>
            <hr/>
        </div><!-- card-body 2 -->
                </div>
                <div class="col-lg-12"><hr/></div>

                <div class="col-lg-6">
                    <!-- ************************attribute binding *************************** -->
                    <div class="card-body">
                    <h5>Attribute binding</h5>
                    href attribute: <a :href="url">Undologic</a><br/>
                    img attruibute:<br> <img :src="img" :alt="alt" /><br/>




                    </div><!-- card-body 3 -->
                </div>
                <div class="col-lg-6">
                    <!-- ************************attribute binding class *************************** -->
                    <div class="card-body">
                        <h5>class binding</h5>

                        class attribute: not workiong
                       <!--<div :class="{ red-background: isActive }">Red background if red is true</div> -->


                    </div><!-- card-body 3 -->
                </div>
    </div><!-- row -->
    </div><!-- /card -->
</div><!-- /#app -->

