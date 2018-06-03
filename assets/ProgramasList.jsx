var Table = Reactstrap.Table;
class ProgramasList extends React.Component {

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

        const rows = this.props.facturas.map((programa,index) =>

                    <tr key={index} data-item={index}

                        onClick={this.handleDetails}>

                    <td>{programa.id}</td>

                    <td>{programa.nombre_compuesto}</td>

                    <td>{programa.num_version}</td>

                    <td>{programa.fecha_publicacion}</td>

                    <td>{programa.lenguaje}</td>
                    
                    <td>{programa.descripcion}</td>
                    
                    <td>{programa.id_usuario}</td></tr>);

        return (

            <Table width="100%" border="1">

              <thead><tr><th>Id</th><th>Version</th><th>Nombre</th>

                    <th>Fecha Publicación</th><th>Lenguaje</th>
                    <th>Descripción</th><th>Programador</th></tr></thead>

              <tbody>

                {rows}

              </tbody>

            </Table>

      );

     }

     return (<p></p>)

    }

}
