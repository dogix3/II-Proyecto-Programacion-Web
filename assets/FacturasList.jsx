var Table = Reactstrap.Table;
class FacturasList extends React.Component {

    constructor(props) {

      super(props)

      this.handleDetails = this.handleDetails.bind(this);

    }

    handleDetails(e) {

        const index = e.currentTarget.getAttribute('data-item');

        this.props.handleChangeFactura(this.props.facturas[index]);

    }

    render() {

      if (this.props.facturas.length > 0) {

        const rows = this.props.facturas.map((factura,index) =>

                    <tr key={index} data-item={index}

                        onClick={this.handleDetails}>

                    <td>{factura.id}</td>

                    <td>{factura.cliente}</td>

                    <td>{factura.fecha}</td>

                    <td>{factura.impuestos}</td>

                    <td>{factura.montoTotal}</td></tr>);

        return (

            <Table width="100%" border="1">

              <thead><tr><th>Id</th><th>Cliente</th><th>Fecha</th>

                    <th>Imp.</th><th>Total</th></tr></thead>

              <tbody>

                {rows}

              </tbody>

            </Table>

      );

     }

     return (<p></p>)

    }

}
