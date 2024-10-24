import { Card } from "antd";
import PropTypes from "prop-types";

import * as Formatter from "../../helpers/formatter";
import UserDropDown from "../Users/UserDropDown";

const Order = ({order}) => {
  const orderTotalPrice = () => order.lines.reduce((result, line) => result + line.price, .0);

  return (
    <Card 
      title={`Commande du ${Formatter.toDateString(order.orderDate.date)} (${orderTotalPrice()}€)`}
      styles={{
        header: {backgroundColor: 'goldenrod'},
        body: {backgroundColor: 'beige'}
      }}
    >
      {
        order.lines.map(line => 
          <Card 
            hoverable
            title={'user ' + line.userId}
            type="inner"  
            key={line.userId + line.sandwichId}
            styles={{
              header: {backgroundColor: 'lightskyblue'},
              body: {backgroundColor: 'lightblue'},
            }}
          >
            Sandwich id: {line.sandwichId} quantity: {line.quantity}
            <br/>
            Total : {line.price} €
          </Card>
        )
      }
      <UserDropDown />
    </Card>
  )
}

export const OrderLinePropType = PropTypes.shape({
  orderId: PropTypes.number,
  userId: PropTypes.number, 
  sandwichId: PropTypes.number,
  price: PropTypes.number,
  quantity: PropTypes.number,
});

export const OrderProptype = PropTypes.shape({
  id: PropTypes.number, 
  orderDate: PropTypes.oneOfType([PropTypes.string, PropTypes.object]), 
  isPaid: PropTypes.bool,
  lines: PropTypes.arrayOf(OrderLinePropType),
});

Order.propTypes = {
  order: OrderProptype
};

export default Order;