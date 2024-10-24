import Order from "./Order";
import { useOrders } from "../../API/features/orders/useOrders";
import { Flex } from "antd";
import { useLocation } from "react-router-dom";
import Header from "../Navigation/Header";

const OrderList = () => {
  const location = useLocation();
  const userId = location?.userId;

  const orders = useOrders({ param: userId });

  if (orders.data == null) return <div>Chargement...</div>;

  return (
    <>
      <Header/>
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

export default OrderList;