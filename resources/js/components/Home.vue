<template>
    <h1>Компания Фаворит-Партс</h1>

    <input class="form-control" v-model="article">
    <div class="d-flex align-items-center">
        <button class="btn btn-info mt-3" @click="getPrices"> Искать</button>
        <div class="form-check mt-3 ms-3 d-inline-block">
            <input class="form-check-input" type="checkbox" v-model="analogs" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">Учитывать аналоги</label>
        </div>
    </div>

    <h2 class="mt-3">Оригинальные запчасти</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Производитель</th>
            <th>Имя</th>
            <th>Артикул</th>
            <th class="pointer">Цена</th>
            <th>Кратность</th>
            <th class="pointer">Дата доставки</th>
            <th class="pointer">Остаток на этом складе</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="(item, indexi) in goods">
            <tr v-for="(warehouse, indexw) in item.warehouses">
                <td>{{ item.brand }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.number }}</td>
                <td>{{ warehouse.price }}</td>
                <td>{{ item.rate }}</td>
                <td>{{ warehouse.shipmentDate }}</td>
                <td>{{ warehouse.stock }}</td>
            </tr>
        </template>
        </tbody>
    </table>

    <h2 v-if="analogs">Аналоги</h2>
    <table class="table" v-if="analogs">
        <thead>
        <tr>
            <th>Производитель</th>
            <th>Имя</th>
            <th>Артикул</th>
            <th class="pointer">Цена</th>
            <th>Кратность</th>
            <th class="pointer">Дата доставки</th>
            <th class="pointer">Остаток на этом складе</th>
        </tr>
        </thead>

        <tbody>
        <template v-for="(item, indexi) in goods">
            <template v-for="(analog, indexa) in item.analogues">
                <template v-for="(warehouse, indexw) in analog.warehouses">
                    <tr>
                        <td>{{ item.brand }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.number }}</td>
                        <td>{{ warehouse.price }}</td>
                        <td>{{ item.rate }}</td>
                        <td>{{ warehouse.shipmentDate }}</td>
                        <td>{{ warehouse.stock }}</td>
                    </tr>
                </template>
            </template>
        </template>
        </tbody>
    </table>

</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            goods: null,
            article: 'OC90',
            brand: 'MAHLE',
            analogs: false,
        }
    },
    methods: {
        async getPrices() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("code", this.article);
            urlencoded.append("analogs", this.analogs);

            var requestOptions =
                {
                    method: 'POST',
                    headers: myHeaders,
                    body: urlencoded,
                    redirect: 'follow'
                };

            var response = await fetch("api/get-prices", requestOptions);

            if (response.ok) {
                var goods = await response.json();
                this.goods = goods[0].goods;
            }
        },
    },
    mounted() {
    }
}
</script>

<style scoped>
.pointer {
    cursor: pointer;
}
</style>
