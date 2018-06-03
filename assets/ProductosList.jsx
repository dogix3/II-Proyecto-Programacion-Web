var Table = Reactstrap.Table;
class ProductosList extends React.Component {
    constructor(props) {
      super(props)
      this.handleDetails = this.handleDetails.bind(this);
    }
    handleDetails(e) {
        const index = e.currentTarget.getAttribute('data-item');
        this.props.handleChangeProducto(this.props.productos[index]);
    }
    render() {
      if (this.props.productos.length > 0) {
          const rows = this.props.productos.map((producto,index) => 

                      (producto.id_factura == this.props.factura.id) ?
                      <tr key={index} data-item={index}
                          onClick={this.handleDetails}>
                      <td>{producto.id}</td>
                      <td>{producto.id_factura}</td>
                      <td>{producto.cantidad}</td>
                      <td>{producto.descripcion}</td> 
                      <td>{producto.valUnit}</td> 
                      <td>{producto.subTotal}</td></tr> 
                      : ''
                      );
          return (
              <table width="100%" border="1">
                <thead><tr><th>Id</th><th>Id_factura</th><th>Cantidad</th>
                  <th>Descripcion</th><th>ValUnit</th><th>SubTotal</th></tr></thead>
                <tbody>
                  {rows}
                </tbody>
              </table>
          );
        
     }
     return (<p></p>)
    }
}
