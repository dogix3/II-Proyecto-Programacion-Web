var Table = Reactstrap.Table;
class RevisionesList extends React.Component {
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
          const rows = this.props.productos.map((revision,index) => 

                      (revision.id_programa == this.props.factura.id) ?
                      <tr key={index} data-item={index}
                          onClick={this.handleDetails}>
                      <td>{revision.id}</td>
                      <td>{revision.id_programa}</td>
                      <td>{revision.descripcion}</td>
                      <td>{revision.fecha}</td>
                      <td>{revision.id_usuario}</td></tr> 
                      : ''
                      );
          return (
              <table width="100%" border="1">
                <thead><tr><th>Id</th><th>Id programa</th><th>Descipción</th><th>Fecha</th>
                  <th>Programador</th></tr></thead>
                <tbody>
                  {rows}
                </tbody>
              </table>
          );
        
     }
     return (<p></p>)
    }
}
