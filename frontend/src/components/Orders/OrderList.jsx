import PropTypes from "prop-types";
import Order from "./Order";
import { useOrders } from "../../API/features/orders/useOrders";
import { Flex } from "antd";

const OrderList = ({ userId }) => {
  const orders = useOrders({ param: userId });

  if (orders.data == null) return <div>Chargement...</div>;

  return (
    <>
      <h2>Liste des commandes</h2>
      <Flex>
        {
          orders.data.map((order, index) =>
            <Order order={order} key={'order' + index} />
          )
        }
      </Flex>
    </>
  );
}

OrderList.propTypes = {
  userId: PropTypes.number
}

export default OrderList;