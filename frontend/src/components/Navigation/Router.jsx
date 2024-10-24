import { createBrowserRouter, Navigate } from "react-router-dom";

import Introduction from "../Introduction/Introduction";
import OrderList from "../Orders/OrderList";

const router = createBrowserRouter([
  {
    path: '/orders',
    element: <OrderList />
  },
  {
    path: '/orders/:userId',
    element: <OrderList />
  },
  {
    path: '/intro',
    element: <Introduction />
  },
  {
    path: '*',
    element: <Navigate to="/orders" replace />
  }
]);

export default router;