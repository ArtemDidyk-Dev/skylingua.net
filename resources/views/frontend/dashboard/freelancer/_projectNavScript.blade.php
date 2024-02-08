<script>
    $.ajax({
        url: '{{ route('frontend.ajax_projects_count') }}',
        type: 'GET',
        dataType: 'json',

        success: function (json) {
            if (json.success == true) {

                if (json.data.myProposals > 0) {
                    $('#projectsNav .myProposals').show(0);
                    $('#projectsNav .myProposals').text(json.data.myProposals);
                }

                if (json.data.hiredsProjects > 0) {
                    $('#projectsNav .hiredsProjects').show(0);
                    $('#projectsNav .hiredsProjects').text(json.data.hiredsProjects);
                }

                if (json.data.ongoingProjects > 0) {
                    $('#projectsNav .ongoingProjects').show(0);
                    $('#projectsNav .ongoingProjects').text(json.data.ongoingProjects);
                }

                if (json.data.completedProjects > 0) {
                    $('#projectsNav .completedProjects').show(0);
                    $('#projectsNav .completedProjects').text(json.data.completedProjects);
                }

                if (json.data.cancelledProjects > 0) {
                    $('#projectsNav .cancelledProjects').show(0);
                    $('#projectsNav .cancelledProjects').text(json.data.cancelledProjects);
                }

            }
        }
    });
</script>
