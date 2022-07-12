<template>
    <h1 class="page-header">Orders</h1>
    <div class="action-bar">
        <div class="button-section">
            <ul>
                <Link :href="route('dashboard_add_order')" as="li" >
                    <p>Add Order</p>
                </Link>
            </ul>
        </div>
        <div class="search-section">
            <input type="text" placeholder="Search by ID...">
        </div>
    </div>
    <div class="table-section">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Sales Rep</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Delivery Date</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <Link as="tr" v-for="(order,index) in orders" :href="route('dashboard_select_order',[order.id])" >
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ order.id }}</td>
                    <td>{{ order.user_id }}</td>
                    <td>{{ order.customer_name }}</td>
                    <td>{{ order.created_at }}</td>
                    <td>{{ order.proposed_delivery_date	 }}</td>
                    <td>{{ order.delivery_status }}</td>
                </Link>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "index.vue",
    props: ['orders']
}
</script>

<style lang='scss' scoped>

.action-bar{
  width: 100%;
  height: 45px;
  background-color: white;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0px 10px;

  .button-section{
    width: 300px;
    height: 100%;

    ul{
      display: flex;
      align-items: center;
      height: 100%;
      li{
        background-color: red;
        width: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        border-radius: 5px;

        p{
          width: auto;
          height: auto;
          color: white;
          padding: 5px 8px;
          font-size: 0.95em;
        }
      }
    }
  }

  .search-section{
    width: 300px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    input{
      height: 32px;
      border-radius: 8px;
    }
  }
}

.table-section{
  margin: auto;
  width: 98%;
  box-shadow: 0 0 6px grey;
  background-color: white;

  thead{
    background-color: red;
    color: white;
    tr:first-of-type{
      border-left: none;
    }
    th{
    }
  }

  tbody{
    tr{
      cursor: pointer;
    }
  }
}
</style>