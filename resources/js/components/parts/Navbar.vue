<template>
    <div>
        <div class=" container-fluid bg-warning mb-2 color-white">
            <div class="row text-white">
                <div class="col-md-2 ">
                    <h1>Contact List</h1>
                </div>
                <div class="col-md-10 mt-2">
                    <h3>{{ timestamp }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script type = "text/javascript">
export  default {
    data() {
        return{
            timestamp:new Date().getFullYear()
        }

    },
    created() {
        setInterval(this.getNow, 1000);
    },
    methods: {
        getNow: function () {
            let today = new Date();
            let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date + ' ' + time;
            this.timestamp = dateTime;
        }
    }
}
</script>
