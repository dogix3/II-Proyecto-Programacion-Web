var Table = Reactstrap.Table;
class RevisionesList extends React.Component {
    constructor(props) {
      super(props)
      this.handleDetails = this.handleDetails.bind(this);
    }
    handleDetails(e) {
        const index = e.currentTarget.getAttribute('data-item');
        this.props.handleChangeRevision(this.props.revisiones[index]);
    }
    render() {
      if (this.props.revisiones.length > 0) {
          const rows = this.props.revisiones.map((revision,index) => 

                      (revision.id_programa == this.props.programa.id) ?
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
              <Table width="100%" border="1">
                <thead><tr><th>Id</th><th>Id programa</th><th>Descipción</th><th>Fecha</th>
                  <th>Programador</th></tr></thead>
                <tbody>
                  {rows}
                </tbody>
              </Table>
          );
        
     }
     return (<p></p>)
    }
}
