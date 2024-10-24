import PropTypes from "prop-types";
import Order from "./Order";
import { Card } from "antd";
import { useOrders } from "../../API/features/orders/useOrders";

const OrderList = ({userId}) => {
  const orders = useOrders({param: userId});

  if(orders.data == null) return <div>Chargement...</div>;

  return (
      <Card 
        title={`Liste des commandes`}
        styles={{
          header: {backgroundColor: 'slategray'},
          body: {backgroundColor: 'azure'},
        }}
      >        
      {
        orders.data.map(order => 
          <Order order={order} key={order.id}/>
        )
      }
      </Card>
  );
}

OrderList.propTypes = {
  userId: PropTypes.number
}

export default OrderList;